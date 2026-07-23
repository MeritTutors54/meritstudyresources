<?php

namespace App\Models;

use App\Enums\FaqGenre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'status',
        'genre'
    ];

    protected $casts = [
        'genre' => FaqGenre::class,
    ];
}
