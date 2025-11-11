<?php

namespace App\Enums;

enum SubscriptionDuration: int
{
    case MONTHLY = 0;
    case YEARLY = 1;

    public static function fromString(string $name): ?self
    {
        return match (strtolower($name)) {
            'month', 'monthly' => self::MONTHLY,
            'year', 'yearly' => self::YEARLY,
            default => null, // return null or throw an exception
        };
    }
}
