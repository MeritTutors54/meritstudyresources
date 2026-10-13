<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonResourceType extends BaseModel
{
    use HasFactory;

    protected $table = 'lesson_resource_types';

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

    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class, 'resource_type_id');
    }
}
