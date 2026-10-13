<?php

namespace App\Services;

use App\Models\CurriculumCourse;
use App\Models\CurriculumLesson;
use App\Models\CurriculumUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

/**
 * Unit and lesson numbers, lesson codes and default weeks.
 *
 * Why this exists: the database keeps (course_id, unit_number), (unit_id, lesson_number)
 * and lesson `code` unique — and soft-deleted rows still count. So:
 *   - a deleted unit/lesson "parks" its number at 50000+ (and a lesson its code as DEL-…),
 *     freeing the real number for new rows;
 *   - reordering writes in two passes (temporary numbers first), so no step clashes.
 */
final class CurriculumNumberingService
{
    private const PARK_FROM = 50000;   // numbers at/above this belong to deleted rows
    private const TEMP_FROM = 40000;   // used only inside a reorder

    /** Next free number among the live rows of a parent (e.g. next unit number in a course). */
    public static function next(string $model, string $column, array $scope): int
    {
        return (int) $model::query()
            ->where($scope)
            ->where($column, '<', self::TEMP_FROM)
            ->max($column) + 1;
    }

    /** Move a row that is being deleted out of the way of live numbering. */
    public static function park(Model $row, string $column, array $scope): void
    {
        $highest = (int) $row::withTrashed()->where($scope)->max($column);
        $row->{$column} = max(self::PARK_FROM, $highest) + 1;

        if ($row instanceof CurriculumLesson) {
            $row->code = substr('DEL' . $row->id . '-' . $row->code, 0, 30);
        }

        $row->save();
    }

    /**
     * Rewrite numbers 1..n in the order of $ids.
     * $ids must be exactly the live rows of the parent — anything else is refused.
     */
    public static function reorder(string $model, string $column, array $scope, array $ids): void
    {
        $rows = $model::query()->where($scope)->get()->keyBy('id');
        $ids = array_values(array_map('intval', $ids));

        if (count($ids) !== $rows->count() || array_diff($ids, $rows->keys()->all()) !== [] || count(array_unique($ids)) !== count($ids)) {
            throw ValidationException::withMessages([
                'ids' => 'The order could not be saved because the list changed. Reload the page and try again.',
            ]);
        }

        foreach ($ids as $i => $id) {                      // pass 1: temporary numbers
            $rows[$id]->update([$column => self::TEMP_FROM + $i]);
        }
        foreach ($ids as $i => $id) {                      // pass 2: final numbers
            $rows[$id]->update([$column => $i + 1]);
        }
    }

    /** Lesson code, e.g. Y3-U01-L07. "year-3" gives 3; other years use their slug, e.g. "reception" gives REC. */
    public static function lessonCode(CurriculumCourse $course, int $unitNumber, int $lessonNumber): string
    {
        $slug = (string) $course->year?->slug;
        $year = preg_match('/(\d+)/', $slug, $m) ? $m[1] : strtoupper(substr(str_replace('-', '', $slug), 0, 3));

        return sprintf('Y%s-U%02d-L%02d', $year ?: 'X', $unitNumber, $lessonNumber);
    }

    /** Lessons of a course in teaching order: unit_number, then lesson_number. */
    public static function lessonsInOrder(CurriculumCourse $course): Collection
    {
        return CurriculumLesson::query()
            ->join('curriculum_units', 'curriculum_units.id', '=', 'curriculum_lessons.unit_id')
            ->where('curriculum_units.course_id', $course->id)
            ->whereNull('curriculum_units.deleted_at')
            ->orderBy('curriculum_units.unit_number')
            ->orderBy('curriculum_lessons.lesson_number')
            ->select('curriculum_lessons.*', 'curriculum_units.unit_number as unit_position')
            ->get();
    }

    /** Default week for a lesson at a 0-based position in the course: 2 lessons a week (as the seeder). */
    public static function weekFor(int $position): int
    {
        return intdiv($position, 2) + 1;
    }

    /**
     * Rebuild a course's numbering from the current order: unit and lesson numbers become 1..n
     * (closing gaps left by deletes), then every lesson code — and optionally every week.
     * Two passes each, so nothing clashes on the way.
     */
    public static function renumberCourse(CurriculumCourse $course, bool $weeksToo): int
    {
        $course->loadMissing('year');

        // 1. Close gaps left by deleted units/lessons: numbers become 1..n in the current order.
        $unitIds = CurriculumUnit::query()->where('course_id', $course->id)->orderBy('unit_number')->pluck('id')->all();
        if ($unitIds) {
            self::reorder(CurriculumUnit::class, 'unit_number', ['course_id' => $course->id], $unitIds);
        }
        foreach ($unitIds as $unitId) {
            $lessonIds = CurriculumLesson::query()->where('unit_id', $unitId)->orderBy('lesson_number')->pluck('id')->all();
            if ($lessonIds) {
                self::reorder(CurriculumLesson::class, 'lesson_number', ['unit_id' => $unitId], $lessonIds);
            }
        }

        // 2. Codes (and weeks) from that order.
        $lessons = self::lessonsInOrder($course);

        foreach ($lessons as $lesson) {                    // pass 1: temporary codes
            $lesson->update(['code' => 'TMP-' . $lesson->id]);
        }
        foreach ($lessons->values() as $position => $lesson) {   // pass 2: final codes
            $changes = ['code' => self::lessonCode($course, (int) $lesson->unit_position, (int) $lesson->lesson_number)];
            if ($weeksToo) {
                $changes['week_number'] = self::weekFor($position);
            }
            $lesson->update($changes);
        }

        return $lessons->count();
    }
}
