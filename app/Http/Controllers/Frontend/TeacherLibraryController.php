<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Models\CourseDocument;
use App\Models\CurriculumCourse;
use App\Models\CurriculumLesson;
use App\Models\DownloadHistory;
use App\Models\LessonResource;
use App\Operations\Frontend\DeviceActivity;
use App\Services\TeacherLibraryAccess;
use App\Services\TeacherLibraryFileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Teacher Library — public pages.
 *
 *   /teacher-resources                       → course page (first course, or ?phase=&year=&subject=)
 *   /teacher-resources/{course}              → old/shared link, redirects to the address above
 *   /teacher-resources/{course}/{id}/{slug}  → lesson page: its files
 *   POST /teacher-resources/files/{file}/download      (login) → checked download
 *   GET  /teacher-resources/{course}/documents/{doc}   (login) → curriculum map / planning / assessment
 *
 * (The admin screens stay at /admin/teacher-library.)
 *
 * Only active rows are shown: phase, year, subject, course, unit, lesson and file must all be active.
 * Who may download is decided in App\Services\TeacherLibraryAccess.
 */
class TeacherLibraryController extends Controller
{
    private const ACTIVE = 1;

    private array $cache = [];

    public function index(Request $request): View|RedirectResponse
    {
        $courses = $this->catalogue();

        if ($courses->isEmpty()) {
            return view('frontend.teacherpanel.empty');
        }

        // Keep each filter that still finds a course, in order phase → year → subject.
        $match = $courses;
        $tests = [
            [(string) $request->query('phase'), fn ($c, $v) => $c->year->phase->slug === $v],
            [(string) $request->query('year'), fn ($c, $v) => $c->year->slug === $v],
            [(string) $request->query('subject'), fn ($c, $v) => $c->subject->slug === $v],
        ];

        foreach ($tests as [$value, $test]) {
            if ($value === '') {
                continue;
            }
            $narrowed = $match->filter(fn ($c) => $test($c, $value));
            if ($narrowed->isNotEmpty()) {
                $match = $narrowed;
            }
        }

        // Show the course right here — the address stays /teacher-resources(?year=…&subject=…)
        return $this->show($match->first());
    }

    /** Old/shared links like /teacher-library/year-3-maths → the /teacher-library address. */
    public function course(CurriculumCourse $course): RedirectResponse
    {
        $this->abortUnlessVisible($course);

        return redirect($this->courseUrl($course), 301);
    }

    private function show(CurriculumCourse $course): View
    {

        $course->load([
            'year.phase',
            'subject',
            'units' => fn ($q) => $q->where('status', self::ACTIVE)->with([
                'lessons' => fn ($l) => $l->where('status', self::ACTIVE)->with([
                    'resources' => fn ($r) => $this->activeFiles($r),
                ]),
            ]),
            'documents' => fn ($q) => $q->where('status', self::ACTIVE),
        ]);

        // Units with no active lesson are hidden from teachers.
        $units = $course->units->filter(fn ($u) => $u->lessons->isNotEmpty())->values();

        $units->each(function ($unit) {
            $weeks = $unit->lessons->pluck('week_number')->filter();
            $unit->first_week = $weeks->min();
            $unit->last_week = $weeks->max();

            $unit->lessons->each(function ($lesson) {
                // one chip per file type the lesson has (Plan, Slides, Classwork ...)
                $lesson->file_types = $lesson->resources->pluck('type')->unique('id')->sortBy('sort_order')->values();
            });
        });

        return view('frontend.teacherpanel.index', [
            'course'      => $course,
            'units'       => $units,
            'lessonCount' => $units->sum(fn ($u) => $u->lessons->count()),
            'documents'   => $course->documents->groupBy('type'),
            'filters'     => $this->filterMap(),
            'courseUrl'   => $this->courseUrl($course),
        ]);
    }

    public function lesson(CurriculumCourse $course, int $lesson, ?string $slug = null): View|RedirectResponse
    {
        $this->abortUnlessVisible($course);
        $course->load(['year.phase', 'subject']);

        // Every active lesson of the course in teaching order (sidebar + previous / next).
        $units = $course->units()
            ->where('status', self::ACTIVE)
            ->with(['lessons' => fn ($l) => $l->where('status', self::ACTIVE)])
            ->get()
            ->filter(fn ($u) => $u->lessons->isNotEmpty())
            ->values();

        $sequence = $units->flatMap(fn ($u) => $u->lessons)->values();
        $position = $sequence->search(fn ($l) => $l->id === $lesson);
        abort_if($position === false, 404);

        /** @var CurriculumLesson $current */
        $current = $sequence[$position];

        // Old or wrong slug in the address → send to the right one (one address per lesson).
        if ($slug !== $current->slug) {
            return redirect()->route('teacher-resources.lesson', [$course, $current->id, $current->slug], 301);
        }

        $current->load(['resources' => fn ($r) => $this->activeFiles($r)]);
        $unit = $units->firstWhere('id', $current->unit_id);

        $access = new TeacherLibraryAccess(Auth::user());

        if (! Auth::check()) {
            session()->put('url.intended', url()->current());   // come back here after logging in
        }

        return view('frontend.teacherpanel.lesson', [
            'course'   => $course,
            'unit'     => $unit,
            'lesson'   => $current,
            'files'    => $current->resources->map(fn ($file) => [
                'file'  => $file,
                'state' => $access->stateFor($file),
            ]),
            'previous' => $sequence[$position - 1] ?? null,
            'next'     => $sequence[$position + 1] ?? null,
            'access'   => $access,
            'courseUrl' => $this->courseUrl($course),
        ]);
    }

    public function download(Request $request, LessonResource $file): Response|RedirectResponse
    {
        $file->load('lesson.unit.course');
        $lesson = $file->lesson;

        abort_unless(
            (int) $file->status === self::ACTIVE
            && $lesson && (int) $lesson->status === self::ACTIVE
            && $lesson->unit && (int) $lesson->unit->status === self::ACTIVE
            && $lesson->unit->course,
            404
        );
        $this->abortUnlessVisible($lesson->unit->course);

        $back = route('teacher-resources.lesson', [$lesson->unit->course, $lesson->id, $lesson->slug]);
        $access = new TeacherLibraryAccess($request->user());
        $state = $access->stateFor($file);

        if ($state !== TeacherLibraryAccess::OK) {
            return redirect($back)->with('error', $access->message($state));
        }

        if (! Storage::disk(TeacherLibraryFileService::DISK)->exists($file->file_path)) {
            Log::warning('Teacher Library: file missing on disk', ['lesson_resource_id' => $file->id]);

            return redirect($back)->with('error', 'Sorry, this file is not available right now. Please try again later.');
        }

        try {
            DB::transaction(function () use ($request, $file, $access) {
                if ($access->isCharged($file)) {
                    $agent = new Agent();
                    $device = DeviceActivity::getDeviceInfo($request, $agent);

                    DownloadHistory::query()->create([
                        'request_id'         => (string) Str::uuid(),
                        'user_id'            => $access->user()->id,
                        'resource_id'        => null,
                        'lesson_resource_id' => $file->id,
                        'subscription_id'    => $access->subscription()?->id,
                        'ip_address'         => $device['ip'] ?? $request->ip(),
                        'fingerprint'        => DeviceActivity::generateFingerprint($request, $agent),
                        'type'               => ResourceType::LESSON->value,
                        'status'             => 1,
                    ]);
                }

                LessonResource::query()->whereKey($file->id)->increment('download_count');
            });
        } catch (\Throwable $e) {
            Log::error('Teacher Library: download failed', ['lesson_resource_id' => $file->id, 'error' => $e->getMessage()]);

            return redirect($back)->with('error', 'Something went wrong. Please try again.');
        }

        return TeacherLibraryFileService::response(
            $file->file_path,
            $lesson->code . ' ' . $file->title,
            inline: false
        );
    }

    public function document(Request $request, CurriculumCourse $course, CourseDocument $document): Response|RedirectResponse
    {
        $this->abortUnlessVisible($course);
        abort_unless($document->course_id === $course->id && (int) $document->status === self::ACTIVE, 404);

        $access = new TeacherLibraryAccess($request->user());

        if (! $access->canOpenDocuments()) {
            return redirect($this->courseUrl($course))
                ->with('error', $access->message(TeacherLibraryAccess::SUBSCRIBE));
        }

        return TeacherLibraryFileService::response($document->file_path, $course->title . ' ' . $document->title);
    }

    // ------------------------------------------------------------------

    /** Active courses whose year, phase and subject are active too — in menu order. */
    private function catalogue(): Collection
    {
        return $this->cache['catalogue'] ??= CurriculumCourse::query()
            ->where('curriculum_courses.status', self::ACTIVE)
            ->join('curriculum_years', 'curriculum_years.id', '=', 'curriculum_courses.year_id')
            ->join('curriculum_phases', 'curriculum_phases.id', '=', 'curriculum_years.phase_id')
            ->join('curriculum_subjects', 'curriculum_subjects.id', '=', 'curriculum_courses.subject_id')
            ->where('curriculum_years.status', self::ACTIVE)
            ->where('curriculum_phases.status', self::ACTIVE)
            ->where('curriculum_subjects.status', self::ACTIVE)
            ->whereNull('curriculum_years.deleted_at')
            ->whereNull('curriculum_phases.deleted_at')
            ->whereNull('curriculum_subjects.deleted_at')
            ->orderBy('curriculum_phases.sort_order')
            ->orderBy('curriculum_years.sort_order')
            ->orderBy('curriculum_subjects.sort_order')
            ->select('curriculum_courses.*')
            ->with(['year.phase', 'subject'])
            ->get();
    }

    /** Phase → years → subjects (each with its course URL), for the three filter boxes. */
    private function filterMap(): array
    {
        return $this->catalogue()
            ->groupBy(fn ($c) => $c->year->phase->id)
            ->map(fn ($byPhase) => [
                'slug'  => $byPhase->first()->year->phase->slug,
                'name'  => $byPhase->first()->year->phase->name,
                'years' => $byPhase->groupBy('year_id')->map(fn ($byYear) => [
                    'slug'     => $byYear->first()->year->slug,
                    'name'     => $byYear->first()->year->name,
                    'subjects' => $byYear->map(fn ($c) => [
                        'slug' => $c->subject->slug,
                        'name' => $c->subject->name,
                        'url'  => $this->courseUrl($c),
                    ])->values()->all(),
                ])->values()->all(),
            ])
            ->values()
            ->all();
    }

    /**
     * The address of a course page: /teacher-resources for the first course,
     * /teacher-resources?phase=primary&year=year-4&subject=english for the others.
     */
    private function courseUrl(CurriculumCourse $course): string
    {
        $course->loadMissing(['year.phase', 'subject']);
        $first = $this->cache['first'] ??= $this->catalogue()->first()?->id;

        return $course->id === $first
            ? route('teacher-resources.index')
            : route('teacher-resources.index', [
                'phase'   => $course->year->phase->slug,
                'year'    => $course->year->slug,
                'subject' => $course->subject->slug,
            ]);
    }

    private function activeFiles($query)
    {
        return $query->where('status', self::ACTIVE)
            ->whereHas('type', fn (Builder $t) => $t->where('status', self::ACTIVE))
            ->with('type');
    }

    private function abortUnlessVisible(CurriculumCourse $course): void
    {
        $course->loadMissing(['year.phase', 'subject']);

        abort_unless(
            (int) $course->status === self::ACTIVE
            && $course->year && (int) $course->year->status === self::ACTIVE
            && $course->year->phase && (int) $course->year->phase->status === self::ACTIVE
            && $course->subject && (int) $course->subject->status === self::ACTIVE,
            404
        );
    }
}
