<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CourseDocumentRequest;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumCourseRequest;
use App\Models\CurriculumCourse;
use App\Models\CurriculumPhase;
use App\Models\CurriculumSubject;
use App\Models\CurriculumYear;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Step 4 — Courses (one year + one subject, e.g. "Year 3 Maths").
 * show() is the course hub: details, units in teaching order, documents.
 */
class CurriculumCourseController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        // $this->authorize('viewCurriculumCourse', Auth::user());

        $filters = $request->only(['phase_id', 'year_id', 'subject_id']);

        $courses = CurriculumCourse::query()
            ->with(['year.phase', 'subject'])
            ->withCount(['units', 'lessons'])
            ->when($filters['phase_id'] ?? null, fn ($q, $id) => $q->whereHas('year', fn ($y) => $y->where('phase_id', $id)))
            ->when($filters['year_id'] ?? null, fn ($q, $id) => $q->where('year_id', $id))
            ->when($filters['subject_id'] ?? null, fn ($q, $id) => $q->where('subject_id', $id))
            ->orderBy('title')
            ->get();

        return view('backend.teacher-library.courses.index', [
            'courses'  => $courses,
            'filters'  => $filters,
            'phases'   => CurriculumPhase::query()->orderBy('sort_order')->get(),
            'years'    => $this->years(),
            'subjects' => CurriculumSubject::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        // $this->authorize('createCurriculumCourse', Auth::user());

        return view('backend.teacher-library.courses.form', $this->formData());
    }

    public function store(CurriculumCourseRequest $request): RedirectResponse
    {
        // $this->authorize('createCurriculumCourse', Auth::user());

        $data = $this->prepare($request->validated());

        return $this->save('created', CurriculumCourse::class, null, function () use ($data) {
            // The database allows one row per year + subject, deleted rows included.
            // If this course was deleted before, bring it back with the new details.
            $deleted = CurriculumCourse::onlyTrashed()
                ->where('year_id', $data['year_id'])
                ->where('subject_id', $data['subject_id'])
                ->first();

            if ($deleted) {
                $data['slug'] = UniqueSlugService::make(CurriculumCourse::class, $data['title'], $deleted->id);
                $deleted->restore();
                $deleted->update($data);

                return $deleted;
            }

            $data['slug'] = UniqueSlugService::make(CurriculumCourse::class, $data['title']);

            return CurriculumCourse::query()->create($data);
        }, 'Course saved. Add its units below.', fn ($course) => route('admin.teacher-library.courses.show', $course));
    }

    /** The course hub. */
    public function show(CurriculumCourse $course): View
    {
        // $this->authorize('viewCurriculumCourse', Auth::user());

        $course->load([
            'year.phase',
            'subject',
            'units' => fn ($q) => $q->withCount('lessons'),
            'documents',
        ])->loadCount('lessons');

        return view('backend.teacher-library.courses.show', [
            'course'        => $course,
            'documentTypes' => CourseDocumentRequest::TYPES,
            'terms'         => CourseDocumentRequest::TERMS,
        ]);
    }

    public function edit(CurriculumCourse $course): View
    {
        // $this->authorize('updateCurriculumCourse', Auth::user());

        return view('backend.teacher-library.courses.form', $this->formData() + ['item' => $course]);
    }

    public function update(CurriculumCourseRequest $request, CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('updateCurriculumCourse', Auth::user());

        $data = $this->prepare($request->validated());
        $before = clone $course;

        return $this->save('updated', CurriculumCourse::class, $before, function () use ($data, $course) {
            if ($data['title'] !== $course->title) {
                $data['slug'] = UniqueSlugService::make(CurriculumCourse::class, $data['title'], $course->id);
            }

            $course->update($data);

            return $course;
        }, 'Course updated successfully.', route('admin.teacher-library.courses.show', $course));
    }

    public function destroy(CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('deleteCurriculumCourse', Auth::user());

        if ($course->units()->exists()) {
            return $this->refuse(
                "\"{$course->title}\" still has units. Delete its units first.",
                route('admin.teacher-library.courses.show', $course)
            );
        }

        $before = clone $course;

        return $this->save('deleted', CurriculumCourse::class, $before, function () use ($course) {
            $course->documents()->each(fn ($doc) => $doc->delete());   // soft delete its documents too
            $course->delete();

            return $course;
        }, 'Course deleted successfully.', route('admin.teacher-library.courses.index'));
    }

    // ------------------------------------------------------------------

    /** Fill defaults the admin left empty. */
    private function prepare(array $data): array
    {
        if (blank($data['title'] ?? null)) {
            $year = CurriculumYear::query()->find($data['year_id']);
            $subject = CurriculumSubject::query()->find($data['subject_id']);
            $data['title'] = trim(($year?->name ?? '') . ' ' . ($subject?->name ?? ''));
        }

        // Fields left empty are missing from validated() — fall back to the defaults.
        $data['curriculum_label'] = ($data['curriculum_label'] ?? null) ?: 'England National Curriculum';
        $data['planned_weeks'] = ($data['planned_weeks'] ?? null) ?: 36;
        $data['intro'] = $data['intro'] ?? null;

        return $data;
    }

    private function years()
    {
        return CurriculumYear::query()
            ->with('phase')
            ->join('curriculum_phases', 'curriculum_phases.id', '=', 'curriculum_years.phase_id')
            ->orderBy('curriculum_phases.sort_order')
            ->orderBy('curriculum_years.sort_order')
            ->select('curriculum_years.*')
            ->get();
    }

    private function formData(): array
    {
        return [
            'yearsByPhase' => $this->years()->groupBy(fn ($y) => $y->phase?->name ?? 'Other'),
            'subjects'     => CurriculumSubject::query()->orderBy('sort_order')->get(),
        ];
    }
}
