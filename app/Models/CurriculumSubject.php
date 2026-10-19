<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumSubject extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'curriculum_subjects';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'sort_order',
        'status',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(CurriculumCourse::class, 'subject_id');
    }
}
