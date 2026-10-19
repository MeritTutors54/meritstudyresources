<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumPhase extends BaseModel
{
    use HasFactory, softDeletes;

    protected $table = 'curriculum_phases';

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'status',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE->value);
    }

    public function years(): HasMany
    {
        return $this->hasMany(CurriculumYear::class, 'phase_id')->orderBy('sort_order');
    }
}
