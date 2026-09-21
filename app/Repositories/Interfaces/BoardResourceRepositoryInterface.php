<?php

namespace App\Repositories\Interfaces;

use App\Models\BoardResource;
use Illuminate\Support\Collection;

interface BoardResourceRepositoryInterface extends BaseRepositoryInterface
{
    public function getIndexData(int $categoryId, int $subcategoryId, int $resubcategoryId): array;

    public function getSubcategories(int $categoryId): Collection;

    public function getResubcategories(int $categoryId, int $subcategoryId): Collection;

    public function getParents(int $resubcategoryId): Collection;

    public function getEditData(BoardResource $boardResource): array;

    public function getParent(?int $parentId): ?BoardResource;

    public function resourceTypes(): array;

    public function difficulties(): array;
}
