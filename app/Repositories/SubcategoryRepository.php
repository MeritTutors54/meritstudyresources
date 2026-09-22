<?php

namespace App\Repositories;

use App\Models\SubCategory;
use App\Repositories\Interfaces\SubcategoryRepositoryInterface;

class SubcategoryRepository extends BaseRepository implements SubcategoryRepositoryInterface
{
    public function __construct(SubCategory $subcategory)
    {
        parent::__construct($subcategory);
    }

    public function activeSubcategories(int|string $categoryId)
    {
        return SubCategory::where('is_active', 1)
            ->where('category_id', $categoryId)
            ->orderBy("subcategory_name", "asc")
            ->get();
    }
}
