<?php

namespace App\Services;

use Illuminate\Support\Str;

final class SlugService
{
    public static function generateSlug(string $string): string
    {
        return Str::slug($string);
    }

    public static function slugReverse(string $value): string
    {
        return Str::of($value)
            ->replace('-', ' ')
            ->title(); // Capitalizes each word
    }
}
