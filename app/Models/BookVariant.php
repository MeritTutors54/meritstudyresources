<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['book_category_id', 'book_subject_id', 'description', 'search_text', 'name', 'slug', 'status'];

    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function bookSubject(): BelongsTo
    {
        return $this->belongsTo(BookSubject::class);
    }
}
