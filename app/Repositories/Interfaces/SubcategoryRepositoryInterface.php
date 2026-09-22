<?php

namespace App\Repositories\Interfaces;

interface SubcategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function activeSubcategories(int|string $categoryId);
}
