<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PastPaperYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function isUsed(): HasMany
    {
        return $this->hasMany(PastPaper::class, 'exam_series', 'id');
    }
}
