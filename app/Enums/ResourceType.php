<?php

namespace App\Enums;

enum ResourceType: int
{
    case RESOURCE = 0;
    case PAST_PAPER = 1;
    case HOME_WORK = 2;
    case WORKSHEET_WORK = 3;
    case QUESTION_BANK = 4;
    case VIDEO = 5;
    case LESSON = 6;
    case EXAM_BUILDER = 7;
    case REVISION_GUIDE = 8;
    case TEST = 9;


    public function label(): string
    {
        return match($this) {
            self::RESOURCE => 'Resource',
            self::PAST_PAPER => 'Past Paper',
            self::HOME_WORK => 'Homework',
            self::WORKSHEET_WORK => 'Worksheet',
            self::QUESTION_BANK => 'Question Bank',
            self::VIDEO => 'Video',
            self::LESSON => 'Lesson',
            self::EXAM_BUILDER => 'Exam Builder',
            self::REVISION_GUIDE => 'Revision Guide',
            self::TEST => 'Test',
        };
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            if (!in_array($case, [self::RESOURCE, self::PAST_PAPER], true)) {
                $carry[$case->value] = $case->label();
            }
            return $carry;
        }, []);
    }
}


