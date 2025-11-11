<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSubject extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['book_category_id', 'name', 'slug', 'description', 'status'];

    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
    }
}
