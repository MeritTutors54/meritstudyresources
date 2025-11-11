<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicGroup extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function topicGroup()
    {
        return $this->hasOneThrough(TopicGroup::class, Topic::class, 'id', 'id', 'id', 'topic_group_id');
    }


}
