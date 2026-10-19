<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseDocument extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'course_documents';

    protected $fillable = [
        'course_id',
        'type',
        'term',
        'title',
        'file_path',
        'file_ext',
        'file_size',
        'sort_order',
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
}
