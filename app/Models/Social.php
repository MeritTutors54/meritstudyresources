<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'url',
        'icon',
        'status'
    ];

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => \App\Enums\Social::from($value)->name
        );
    }

}
