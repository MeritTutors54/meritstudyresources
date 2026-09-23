<?php

namespace App\Enums;

enum IconByuddy: string
{
    case Worksheet = '<i class="bi bi-journal-text" aria-hidden="true"></i>';
    case TopicQuestion = '<i class="bi bi-check2-square" aria-hidden="true"></i>';
    case Test = '<i class="bi bi-stopwatch" aria-hidden="true"></i>';
    case Wordbook = '<i class="bi bi-book-half" aria-hidden="true"></i>';
    case WorkedSolution = '<i class="bi bi-lightbulb" aria-hidden="true"></i>';

    public function label(): string
    {
        return match($this) {
            self::Worksheet => 'Worksheet',
            self::TopicQuestion => 'Topic Question',
            self::Test => 'Test',
            self::Wordbook => 'Workbook',
            self::WorkedSolution => 'Worked Solution',
        };
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->label()] = $case->value;

            return $carry;
        }, []);
    }
}
