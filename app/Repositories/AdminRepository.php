<?php

namespace App\Repositories;
use App\Models\Admin;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }
}
