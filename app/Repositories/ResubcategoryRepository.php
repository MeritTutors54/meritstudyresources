<?php

namespace App\Repositories;
use App\Models\Category;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Repositories\Interfaces\ResubcategoryRepositoryInterface;

class ResubcategoryRepository extends BaseRepository implements ResubcategoryRepositoryInterface
{
    public function __construct(Resubcategory $resubcategory)
    {
        parent::__construct($resubcategory);
    }

     public function activeResubcategories(int|string $categoryId, int|string $subcategoryId)
    {
        return Resubcategory::where('is_active', 1)
            ->where('category_id', $categoryId)
            ->where('subcategory_id', $subcategoryId)
            ->orderBy("resubcategory_name", "asc")
            ->get();
    }
}
