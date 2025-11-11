<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class StringService
{

    public static function shortenString(
        string $string,
        int    $startLength = 5,
        int    $endLength = 3,
        string $separator = '.....'): string
    {
        // If the string is too short, return it as is
        if (strlen($string) <= $startLength + $endLength) {
            return $string;
        }

        // Get the first $startLength characters
        $start = substr($string, 0, $startLength);
        // Get the last $endLength characters
        $end = substr($string, -$endLength);

        // Combine with separator
        return $start . $separator . $end;
    }

}
