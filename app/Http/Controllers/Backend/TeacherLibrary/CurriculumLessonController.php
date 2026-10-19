<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumLessonRequest;
use App\Http\Requests\Backend\TeacherLibrary\ReorderRequest;
use App\Models\CurriculumCourse;
use App\Models\CurriculumLesson;
use App\Models\CurriculumUnit;
use App\Models\LessonResourceType;
use App\Services\CurriculumNumberingService;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Step 6 — Lessons (teaching steps) inside a unit. Listed on the unit page.
 * The admin types the title and details; number, code (Y3-U01-L01) and a default week are worked out.
 */
class CurriculumLessonController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(CurriculumUnit $unit): View
    {
        // $this->authorize('createCurriculumLesson', Auth::user());

        $unit->load('course.year');
        [$number, $code, $week] = $this->nextFor($unit);

        return view('backend.teacher-library.lessons.form', [
            'unit' => $unit, 'course' => $unit->course,
            'nextNumber' => $number, 'nextCode' => $code, 'suggestedWeek' => $week,
        ]);
    }

    public function store(CurriculumLessonRequest $request, CurriculumUnit $unit): RedirectResponse
    {
        // $this->authorize('createCurriculumLesson', Auth::user());

        $data = $request->validated();
        $unit->load('course.year');

        return $this->save('created', CurriculumLesson::class, null, function () use ($data, $unit) {
            [$number, $code, $week] = $this->nextFor($unit);
            $this->ensureCodeIsFree($code);

            $data['lesson_number'] = $number;
            $data['code'] = $code;
            $data['week_number'] = $data['week_number'] ?? $week;
            $data['slug'] = UniqueSlugService::make(CurriculumLesson::class, $data['title'], null, ['unit_id' => $unit->id]);

            return $unit->lessons()->create($data);
        }, 'Lesson added. Upload its files below.', fn ($lesson) => route('admin.teacher-library.lessons.show', $lesson));
    }

    /** The lesson page: details + its files (Step 7). */
    public function show(CurriculumLesson $lesson): View
    {
        // $this->authorize('viewCurriculumLesson', Auth::user());

        $lesson->load(['unit.course.year', 'resources.type']);

        return view('backend.teacher-library.lessons.show', [
            'lesson' => $lesson,
            'unit'   => $lesson->unit,
            'course' => $lesson->unit->course,
            'types'  => LessonResourceType::query()->where('status', 1)->orderBy('sort_order')->get(),
        ]);
    }

    public function edit(CurriculumLesson $lesson): View
    {
        // $this->authorize('updateCurriculumLesson', Auth::user());

        $lesson->load('unit.course');

        return view('backend.teacher-library.lessons.form', [
            'unit' => $lesson->unit, 'course' => $lesson->unit->course, 'item' => $lesson,
        ]);
    }

    public function update(CurriculumLessonRequest $request, CurriculumLesson $lesson): RedirectResponse
    {
        // $this->authorize('updateCurriculumLesson', Auth::user());

        $data = $request->validated();
        $before = clone $lesson;

        return $this->save('updated', CurriculumLesson::class, $before, function () use ($data, $lesson) {
            if ($data['title'] !== $lesson->title) {
                $data['slug'] = UniqueSlugService::make(CurriculumLesson::class, $data['title'], $lesson->id, ['unit_id' => $lesson->unit_id]);
            }
            $data['week_number'] = $data['week_number'] ?? $lesson->week_number;
            $lesson->update($data);

            return $lesson;
        }, 'Lesson updated.', route('admin.teacher-library.lessons.show', $lesson));
    }

    public function destroy(CurriculumLesson $lesson): RedirectResponse
    {
        // $this->authorize('deleteCurriculumLesson', Auth::user());

        $unitPage = route('admin.teacher-library.units.show', $lesson->unit_id);

        if ($lesson->resources()->exists()) {
            return $this->refuse(
                "\"{$lesson->title}\" still has files, and download history points at them. Delete its files first.",
                route('admin.teacher-library.lessons.show', $lesson)
            );
        }

        $before = clone $lesson;

        return $this->save('deleted', CurriculumLesson::class, $before, function () use ($lesson) {
            CurriculumNumberingService::park($lesson, 'lesson_number', ['unit_id' => $lesson->unit_id]);
            $lesson->delete();

            return $lesson;
        }, 'Lesson deleted.', $unitPage);
    }

    /** PATCH units/{unit}/lessons/reorder — ids[] in the new order. Codes are not changed. */
    public function reorder(ReorderRequest $request, CurriculumUnit $unit): RedirectResponse
    {
        // $this->authorize('updateCurriculumLesson', Auth::user());

        return $this->save('reordered', CurriculumUnit::class, null, function () use ($request, $unit) {
            CurriculumNumberingService::reorder(CurriculumLesson::class, 'lesson_number', ['unit_id' => $unit->id], $request->validated('ids'));

            return $unit;
        }, 'Lesson order saved. Codes are unchanged — use "Renumber codes" on the course page to update them.', route('admin.teacher-library.units.show', $unit));
    }

    /** POST courses/{course}/renumber — rebuild every lesson code (and weeks when ticked). */
    public function renumber(Request $request, CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('updateCurriculumLesson', Auth::user());

        $weeksToo = $request->boolean('weeks');

        return $this->save('renumbered', CurriculumCourse::class, null, function () use ($course, $weeksToo) {
            CurriculumNumberingService::renumberCourse($course, $weeksToo);

            return $course;
        }, 'Lesson codes rebuilt' . ($weeksToo ? ' and weeks reset' : '') . ' from the current order.', route('admin.teacher-library.courses.show', $course) . '#units');
    }

    // ------------------------------------------------------------------

    /** [lesson number, code, suggested week] for a new lesson at the end of $unit. */
    private function nextFor(CurriculumUnit $unit): array
    {
        $number = CurriculumNumberingService::next(CurriculumLesson::class, 'lesson_number', ['unit_id' => $unit->id]);
        $code = CurriculumNumberingService::lessonCode($unit->course, (int) $unit->unit_number, $number);

        // Position in the course = lessons in earlier units + lessons already in this unit.
        $position = CurriculumNumberingService::lessonsInOrder($unit->course)
            ->filter(fn ($l) => $l->unit_position < $unit->unit_number || $l->unit_id === $unit->id)
            ->count();

        return [$number, $code, CurriculumNumberingService::weekFor($position)];
    }

    private function ensureCodeIsFree(string $code): void
    {
        $taken = CurriculumLesson::withTrashed()->where('code', $code)->first();

        if ($taken) {
            throw ValidationException::withMessages([
                'title' => "The code {$code} is already used by \"{$taken->title}\". Use \"Renumber codes\" on the course page, then add the lesson again.",
            ]);
        }
    }
}
