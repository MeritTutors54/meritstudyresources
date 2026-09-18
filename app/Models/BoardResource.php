<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardResource extends Model
{
    protected $fillable = ['resubcategory_id', 'resource_type', 'parent_id', 'name', 'slug',
        'is_section_title', 'is_group', 'is_paid', 'is_active'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(BoardResourceFile::class);
    }
}
