<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonResource extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'lesson_resources';

    protected $fillable = [
        'lesson_id',
        'resource_type_id',
        'title',
        'file_path',
        'file_ext',
        'file_size',
        'is_paid',
        'is_pro',
        'download_count',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_pro' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(CurriculumLesson::class, 'lesson_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LessonResourceType::class, 'resource_type_id');
    }

    /** Rows in the existing download_histories table */
    public function downloadHistories(): HasMany
    {
        return $this->hasMany(DownloadHistory::class, 'lesson_resource_id');
    }
}
