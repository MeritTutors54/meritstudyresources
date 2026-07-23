<?php

namespace App\Enums;

enum FaqGenre: int
{
    case General = 1;
    case Billing = 2;
    case Resources = 3;
    case School = 4;

    public function label(): string
    {
        return match ($this) {
            self::General => 'General',
            self::Billing => 'Billing',
            self::Resources => 'Resources',
            self::School => 'School',
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
