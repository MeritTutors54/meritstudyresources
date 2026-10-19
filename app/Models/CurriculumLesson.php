<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumLesson extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'curriculum_lessons';

    protected $fillable = [
        'unit_id',
        'lesson_number',
        'code',
        'title',
        'slug',
        'week_number',
        'objective',
        'summary',
        'status',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    /** CurriculumLesson::search('fraction')->get() — matches title or code (Y3-U04) */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $term === '' ? $query : $query->where(fn ($q) => $q
            ->where('title', 'like', "%{$term}%")
            ->orWhere('code', 'like', "%{$term}%"));
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CurriculumUnit::class, 'unit_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class, 'lesson_id')->orderBy('sort_order');
    }
}
