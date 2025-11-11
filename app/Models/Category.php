<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'slug',
        'status',
        'is_active'
    ];

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
}
