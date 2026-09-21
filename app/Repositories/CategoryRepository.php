<?php

namespace App\Repositories;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

     public function activeCategories()
    {
        return Category::where('is_active', 1)
            ->orderBy("category_name", "asc")
            ->get();
    }
}
