<?php

namespace App\Repositories;
use App\Models\Category;
use App\Models\BoardResource;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class BoardResourceRepository extends BaseRepository implements BoardResourceRepositoryInterface
{
    public function __construct(BoardResource $resource)
    {
        parent::__construct($resource);
    }

    public function getParents(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->query()
            ->where('parent_id', null)->get();
    }
}
