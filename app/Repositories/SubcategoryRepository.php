<?php

namespace App\Repositories;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryRepository extends BaseRepository implements SubcategoryRepositoryInterface
{
    public function __construct(Subcategory $subcategory)
    {
        parent::__construct($subcategory);
    }
}
