<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'resubcategory_name',
        'unit_code',
        'slug',
        'category_id',
        'subcategory_id',
        'past_papers',
        'revision_notes',
        'exam_questions',
        'flashcards',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function pastPapers(): HasMany
    {
        return $this->hasMany(PastPaper::class, 'resubcategory');
    }
}
