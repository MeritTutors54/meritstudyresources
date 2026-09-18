<?php

namespace App\Enums;

enum DifficultyType: int
{
    case Easy = 0;
    case Medium = 1;
    case Hard = 2;


    public function label(): string
    {
        return match($this) {
            self::Easy => 'Easy',
            self::Medium => 'Medium',
            self::Hard => 'Hard',
        };
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->label();

            return $carry;
        }, []);
    }
}


