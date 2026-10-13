<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumUnit extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'curriculum_units';

    protected $fillable = [
        'course_id',
        'unit_number',
        'title',
        'slug',
        'summary',
        'status',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(CurriculumCourse::class, 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(CurriculumLesson::class, 'unit_id')->orderBy('lesson_number');
    }
}
