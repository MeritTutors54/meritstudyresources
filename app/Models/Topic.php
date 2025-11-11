<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends BaseModel
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'education_level_id',
        'subject_id',
        'topic_group_id',
        'status',
        'parent_id'
    ];
    public function topicGroup(): BelongsTo
    {
        return $this->belongsTo(TopicGroup::class);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'parent_id');
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Topic::class, 'parent_id');
    }

    public function resources(): HasMany
    {
        return $this->hasMany(MeritResource::class)->orderByDesc('created_at');
    }


//    public function canDeletable(): bool
//    {
//        return !$this->children()->exists() && !$this->resources()->exists();
//    }
}
