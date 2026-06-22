<?php

namespace App\Repositories;
use App\Models\PastPaper;
use App\Repositories\Interfaces\PastPaperRepositoryInterface;

class PastPaperRepository extends BaseRepository implements PastPaperRepositoryInterface
{
    public function __construct(PastPaper $pastPaper)
    {
        parent::__construct($pastPaper);
    }
}
