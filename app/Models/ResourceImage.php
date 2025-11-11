<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'topic_id',
        'image_path',
        'status'
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(MeritResource::class);
    }
}
