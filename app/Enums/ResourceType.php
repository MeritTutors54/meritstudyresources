<?php

namespace App\Enums;

use Illuminate\Support\Str;

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
    case REVISION_NOTES = 10;
    case TOPIC_QUESTION = 11;
    case TOPIC_TEST = 12;
    case WORKBOOKS = 13;
    case WORK_SOLUTIONS = 14;


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
            self::REVISION_NOTES => 'Revision Notes',
            self::TOPIC_QUESTION => 'Topic Question',
            self::TOPIC_TEST => 'Topic Test',
            self::WORKBOOKS => 'Workbooks',
            self::WORK_SOLUTIONS => 'Work Solutions',
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

    public static function fromSlug(string $slug): ?self
    {
        // "revision-guides" -> "revision_guide" -> "REVISION_GUIDE"
        $name = Str::upper(Str::singular(Str::snake(Str::camel($slug))));

        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}


