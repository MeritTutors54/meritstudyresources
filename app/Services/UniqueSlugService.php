<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Unique slugs for the Teacher Library tables.
 * Adds -2, -3 … when the slug is already taken.
 *
 *   UniqueSlugService::make(CurriculumSubject::class, 'Maths');                                // maths
 *   UniqueSlugService::make(CurriculumUnit::class, 'Fractions', $unit->id, ['course_id' => 4]); // unique inside course 4
 */
final class UniqueSlugService
{
    /**
     * @param  class-string<Model>  $model
     * @param  int|null  $ignoreId  the record being edited (keeps its own slug)
     * @param  array<string, mixed>  $scope  extra where-clauses, e.g. ['course_id' => 4]
     */
    public static function make(string $model, string $text, ?int $ignoreId = null, array $scope = [], string $column = 'slug'): string
    {
        $base = SlugService::generateSlug($text) ?: 'item';
        $slug = $base;
        $n = 2;

        while (self::taken($model, $slug, $ignoreId, $scope, $column)) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }

    private static function taken(string $model, string $slug, ?int $ignoreId, array $scope, string $column): bool
    {
        $query = $model::query()->where($column, $slug)->where($scope);

        // Soft-deleted rows still hold their unique slug in the database.
        if (method_exists($model, 'bootSoftDeletes')) {
            $query->withTrashed();
        }

        if ($ignoreId) {
            $query->whereKeyNot($ignoreId);
        }

        return $query->exists();
    }
}