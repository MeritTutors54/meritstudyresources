<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumCourse extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'curriculum_courses';

    protected $fillable = [
        'year_id',
        'subject_id',
        'title',
        'slug',
        'curriculum_label',
        'intro',
        'planned_weeks',
        'has_weekly_homework',
        'status',
    ];

    protected $casts = [
        'has_weekly_homework' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(CurriculumYear::class, 'year_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(CurriculumSubject::class, 'subject_id');
    }

    /** Topics in teaching order — the left sidebar */
    public function units(): HasMany
    {
        return $this->hasMany(CurriculumUnit::class, 'course_id')->orderBy('unit_number');
    }

    /** Every lesson in the course ("72 teaching steps") */
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(CurriculumLesson::class, CurriculumUnit::class, 'course_id', 'unit_id');
    }

    /** Curriculum map, weekly planning, term assessments */
    public function documents(): HasMany
    {
        return $this->hasMany(CourseDocument::class, 'course_id')->orderBy('sort_order');
    }
}
