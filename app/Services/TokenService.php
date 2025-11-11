<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use Random\RandomException;

final class TokenService
{
    /**
     * @throws RandomException
     */
    public static function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    public static function generate64DigitCode(): string
    {
        do {
            // Generate 4 segments of 16 characters each
            $code = Str::random(16) . Str::random(16) . Str::random(16) . Str::random(16);

            // Ensure it's exactly 64 characters
            $code = substr($code, 0, 64);

            // Check uniqueness in your database (example for a 'vouchers' table)
            $exists = Order::query()->where('tracking_number', $code)->exists();
        } while ($exists);

        return $code;
    }
}
