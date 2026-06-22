<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PastPaperService
{
    public static function findCorruptedEntry(Collection $papers)
    {
        $countForError = 0;
        $countForRight = 0;
        $ids = [];
        $corrupted = [];

        foreach ($papers as $paper) {
            // Get the extension in lowercase to handle '.PDF' or '.pdf' safely
            $extension = strtolower(pathinfo($paper->ques_paper, PATHINFO_EXTENSION));

            if ($extension === 'pdf') {
                $countForRight++;
            } else {
                $ids[] = $paper->id;
                $corrupted[] = $paper;
                $countForError++;

                dd($paper->ques_paper);
            }
        }

        dd($corrupted);
    }
}
