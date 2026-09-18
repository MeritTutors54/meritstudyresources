<?php

namespace App\Repositories\Interfaces;

interface BoardResourceRepositoryInterface extends BaseRepositoryInterface
{
    public function getParents():\Illuminate\Database\Eloquent\Collection;
}
