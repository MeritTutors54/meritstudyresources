<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Enums\ResourceType;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\CurriculumCourse;
use App\Models\DownloadHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Step 8 — Teacher Library downloads report (read only).
 * Reads download_histories rows that point at a lesson file (lesson_resource_id set).
 * Nothing here edits or deletes them: they count towards each school's download limit.
 */
class LessonDownloadReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        // $this->authorize('viewLessonDownloads', Auth::user());

        $filters = $this->filters($request);
        $base = $this->query($filters);

        $downloads = (clone $base)
            ->with([
                'user.school',
                'lessonResource' => fn ($q) => $q->withTrashed()->with([
                    'type',
                    'lesson' => fn ($l) => $l->withTrashed()->with(['unit' => fn ($u) => $u->withTrashed()->with(['course' => fn ($c) => $c->withTrashed()])]),
                ]),
            ])
            ->latest('download_histories.created_at')
            ->paginate(25)
            ->withQueryString();

        return view('backend.teacher-library.downloads.index', [
            'downloads'  => $downloads,
            'filters'    => $filters,
            'totals'     => $this->totals($base),
            'topLessons' => $this->topLessons($base),
            'schools'    => User::query()->where('type', UserType::SCHOOL->value)->orderBy('name')->get(['id', 'name']),
            'courses'    => CurriculumCourse::query()->orderBy('title')->get(['id', 'title']),
        ]);
    }

    /** CSV of the filtered rows, streamed so a big month doesn't run out of memory. */
    public function export(Request $request): StreamedResponse
    {
        // $this->authorize('viewLessonDownloads', Auth::user());

        $filters = $this->filters($request);
        $name = 'teacher-library-downloads-' . $filters['from']->format('Ymd') . '-' . $filters['to']->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($filters) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Teacher', 'Teacher email', 'School', 'Course', 'Lesson code', 'Lesson', 'File', 'File type']);

            $this->query($filters)
                ->with([
                    'user.school',
                    'lessonResource' => fn ($q) => $q->withTrashed()->with([
                        'type',
                        'lesson' => fn ($l) => $l->withTrashed()->with(['unit' => fn ($u) => $u->withTrashed()->with(['course' => fn ($c) => $c->withTrashed()])]),
                    ]),
                ])
                ->orderBy('download_histories.id')
                ->chunk(500, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        $file = $row->lessonResource;
                        $lesson = $file?->lesson;
                        fputcsv($out, array_map([$this, 'csvSafe'], [
                            $row->created_at?->format('Y-m-d H:i'),
                            $row->user?->name,
                            $row->user?->email,
                            $this->schoolName($row->user),
                            $lesson?->unit?->course?->title,
                            $lesson?->code,
                            $lesson?->title,
                            $file?->title,
                            $file?->type?->name,
                        ]));
                    }
                });

            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ------------------------------------------------------------------

    /** Date range defaults to the last 30 days. */
    private function filters(Request $request): array
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'school_id' => ['nullable', 'integer'],
            'course_id' => ['nullable', 'integer'],
        ]);

        $to = $request->date('to') ?? now();
        $from = $request->date('from') ?? $to->copy()->subDays(29);

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return [
            'from' => Carbon::parse($from)->startOfDay(),
            'to' => Carbon::parse($to)->endOfDay(),
            'school_id' => $request->integer('school_id') ?: null,
            'course_id' => $request->integer('course_id') ?: null,
        ];
    }

    private function query(array $f): Builder
    {
        return DownloadHistory::query()
            ->whereNotNull('download_histories.lesson_resource_id')
            ->where('download_histories.type', ResourceType::LESSON->value)
            ->whereBetween('download_histories.created_at', [$f['from'], $f['to']])
            // a school = the school account itself + its teachers (users.parent_id)
            ->when($f['school_id'], fn ($q, $id) => $q->whereIn(
                'download_histories.user_id',
                User::query()->where('id', $id)->orWhere('parent_id', $id)->select('id')
            ))
            ->when($f['course_id'], fn ($q, $id) => $q->whereIn(
                'download_histories.lesson_resource_id',
                DB::table('lesson_resources')
                    ->join('curriculum_lessons', 'curriculum_lessons.id', '=', 'lesson_resources.lesson_id')
                    ->join('curriculum_units', 'curriculum_units.id', '=', 'curriculum_lessons.unit_id')
                    ->where('curriculum_units.course_id', $id)
                    ->select('lesson_resources.id')
            ));
    }

    private function totals(Builder $base): array
    {
        $schools = (clone $base)
            ->join('users', 'users.id', '=', 'download_histories.user_id')
            ->distinct()
            ->count(DB::raw('COALESCE(users.parent_id, users.id)'));

        return [
            'downloads' => (clone $base)->count(),
            'schools'   => $schools,
            'teachers'  => (clone $base)->distinct()->count('download_histories.user_id'),
        ];
    }

    /** The 5 most downloaded lessons in the range. */
    private function topLessons(Builder $base)
    {
        return (clone $base)
            ->join('lesson_resources', 'lesson_resources.id', '=', 'download_histories.lesson_resource_id')
            ->join('curriculum_lessons', 'curriculum_lessons.id', '=', 'lesson_resources.lesson_id')
            ->groupBy('curriculum_lessons.id', 'curriculum_lessons.code', 'curriculum_lessons.title')
            ->orderByDesc('downloads')
            ->limit(5)
            ->get([
                'curriculum_lessons.id',
                'curriculum_lessons.code',
                'curriculum_lessons.title',
                DB::raw('COUNT(*) as downloads'),
            ]);
    }

    private function schoolName(?User $user): ?string
    {
        if (! $user) {
            return null;
        }

        return $user->type === UserType::SCHOOL->value ? $user->name : $user->school?->name;
    }

    /** Stop spreadsheet formula injection: a cell starting with = + - @ is shown as text. */
    private function csvSafe($value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@\t\r]/', $value) ? "'" . $value : $value;
    }
}
