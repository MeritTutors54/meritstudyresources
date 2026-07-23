<?php

namespace App\Enums;

enum Policy: int
{
    case Privacy = 1;
    case Terms = 2;
    case Return = 3;
    case Refund = 4;

    public function label(): string
    {
        return match ($this) {
            self::Privacy => 'Privacy Policy',
            self::Terms => 'Terms and Conditions',
            self::Return => 'Return Policy',
            self::Refund => 'Refund Policy',
        };
    }

    public static function array(): array
    {
        return array_column(
            array_map(fn ($case) => ['id' => $case->value, 'name' => $case->label()], self::cases()),
            'name',
            'id'
        );
    }
}
