<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumUnitRequest;
use App\Http\Requests\Backend\TeacherLibrary\ReorderRequest;
use App\Models\CurriculumCourse;
use App\Models\CurriculumUnit;
use App\Services\CurriculumNumberingService;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Step 5 — Units (topics) inside a course. Listed on the course hub.
 * show() is the unit page: its lessons in order.
 */
class CurriculumUnitController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(CurriculumCourse $course): View
    {
        // $this->authorize('createCurriculumUnit', Auth::user());

        return view('backend.teacher-library.units.form', [
            'course'     => $course,
            'nextNumber' => CurriculumNumberingService::next(CurriculumUnit::class, 'unit_number', ['course_id' => $course->id]),
        ]);
    }

    public function store(CurriculumUnitRequest $request, CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('createCurriculumUnit', Auth::user());

        $data = $request->validated();

        return $this->save('created', CurriculumUnit::class, null, function () use ($data, $course) {
            $data['unit_number'] = CurriculumNumberingService::next(CurriculumUnit::class, 'unit_number', ['course_id' => $course->id]);
            $data['slug'] = UniqueSlugService::make(CurriculumUnit::class, $data['title'], null, ['course_id' => $course->id]);

            return $course->units()->create($data);
        }, 'Unit added.', fn ($unit) => route('admin.teacher-library.units.show', $unit));
    }

    /** The unit page: lessons in order, with a search box. */
    public function show(Request $request, CurriculumUnit $unit): View
    {
        // $this->authorize('viewCurriculumUnit', Auth::user());

        $q = trim((string) $request->query('q'));

        $unit->load('course.year', 'course.subject');
        $lessons = $unit->lessons()
            ->search($q)
            ->with('resources.type')
            ->withCount('resources')
            ->get();

        return view('backend.teacher-library.units.show', [
            'unit'    => $unit,
            'course'  => $unit->course,
            'lessons' => $lessons,
            'q'       => $q,
        ]);
    }

    public function edit(CurriculumUnit $unit): View
    {
        // $this->authorize('updateCurriculumUnit', Auth::user());

        return view('backend.teacher-library.units.form', ['course' => $unit->course, 'item' => $unit]);
    }

    public function update(CurriculumUnitRequest $request, CurriculumUnit $unit): RedirectResponse
    {
        // $this->authorize('updateCurriculumUnit', Auth::user());

        $data = $request->validated();
        $before = clone $unit;

        return $this->save('updated', CurriculumUnit::class, $before, function () use ($data, $unit) {
            if ($data['title'] !== $unit->title) {
                $data['slug'] = UniqueSlugService::make(CurriculumUnit::class, $data['title'], $unit->id, ['course_id' => $unit->course_id]);
            }
            $unit->update($data);

            return $unit;
        }, 'Unit updated.', route('admin.teacher-library.units.show', $unit));
    }

    public function destroy(CurriculumUnit $unit): RedirectResponse
    {
        // $this->authorize('deleteCurriculumUnit', Auth::user());

        $hub = route('admin.teacher-library.courses.show', $unit->course_id) . '#units';

        if ($unit->lessons()->exists()) {
            return $this->refuse("\"{$unit->title}\" still has lessons. Delete its lessons first.", $hub);
        }

        $before = clone $unit;

        return $this->save('deleted', CurriculumUnit::class, $before, function () use ($unit) {
            CurriculumNumberingService::park($unit, 'unit_number', ['course_id' => $unit->course_id]);
            $unit->delete();

            return $unit;
        }, 'Unit deleted. Use "Renumber codes" if lesson codes should close the gap.', $hub);
    }

    /** PATCH courses/{course}/units/reorder — ids[] in the new teaching order. */
    public function reorder(ReorderRequest $request, CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('updateCurriculumUnit', Auth::user());

        return $this->save('reordered', CurriculumCourse::class, null, function () use ($request, $course) {
            CurriculumNumberingService::reorder(CurriculumUnit::class, 'unit_number', ['course_id' => $course->id], $request->validated('ids'));

            return $course;
        }, 'Unit order saved. Lesson codes are unchanged — use "Renumber codes" to update them.', route('admin.teacher-library.courses.show', $course) . '#units');
    }
}
