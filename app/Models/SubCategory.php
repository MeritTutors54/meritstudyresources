<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory_name',
        'category_id',
        'slug',
        'is_active',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function resubcategories(): HasMany
    {
        return $this->hasMany(Resubcategory::class, 'subcategory_id');
    }

    public function pastPapers(): HasMany
    {
        return $this->hasMany(Pastpaper::class, 'subcategory');
    }
}
