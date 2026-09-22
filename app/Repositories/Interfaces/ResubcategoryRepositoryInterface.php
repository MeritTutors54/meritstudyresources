<?php

namespace App\Repositories\Interfaces;

interface ResubcategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function activeResubcategories(int|string $categoryId, int|string $subcategory);
}
