<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\BoardResource;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Enums\DifficultyType;
use App\Enums\ResourceType;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use Illuminate\Support\Collection;

class BoardResourceRepository extends BaseRepository implements BoardResourceRepositoryInterface
{
    public function __construct(
        BoardResource $resource,
        protected CategoryRepositoryInterface $categoryRepo,
    ) {
        parent::__construct($resource);
    }

    public function getIndexData(int $categoryId, int $subcategoryId, int $resubcategoryId): array
    {
        return [
            'selectedCategory' => $categoryId,
            'selectedSubCategory' => $subcategoryId,
            'selectedResubcategory' => $resubcategoryId,
            'subcategories' => $this->getSubcategories($categoryId),
            'resubcategories' => $this->getResubcategories($categoryId, $subcategoryId),
            'syllabus' => $this->getSyllabus($resubcategoryId),
        ];
    }

    public function getSubcategories(int $categoryId): Collection
    {
        return SubCategory::query()->where('category_id', $categoryId)->get();
    }

    public function getResubcategories(int $categoryId, int $subcategoryId): Collection
    {
        return Resubcategory::query()->where('category_id', $categoryId)->where('subcategory_id', $subcategoryId)->get();
    }

    public function getSyllabus(int $resubcategoryId, int $isActiveCheck = 0): array
    {
        $resourceTypes = ResourceType::options();

        return BoardResource::query()->with([
            'children.children.files',
            'children.files',
            'files',
        ])->where('resubcategory_id', $resubcategoryId)
            ->whereNull('parent_id')
            ->when($isActiveCheck === 1, function ($query) {
                $query->where('is_active', 1);
            })
            ->get()
            ->groupBy('resource_type')
            ->mapWithKeys(function ($resources, $type) use ($resourceTypes) {
                return [$resourceTypes[$type] ?? $type => $resources,];
            })
            ->toArray();
    }

    public function getParents(int $resubcategoryId): Collection
    {
        return BoardResource::query()
            ->where('resubcategory_id', $resubcategoryId)
            ->where('is_group', true)
            ->get();
    }

    public function getParent(?int $parentId): ?BoardResource
    {
        if (!$parentId) {
            return null;
        }

        return BoardResource::query()->find($parentId);
    }

    public function getEditData(BoardResource $boardResource): array
    {
        $boardResource->load('examBoard');
        $examBoard = $boardResource->examBoard;
        $subCategories = $this->getSubcategories($examBoard->category_id);
        $boards = $this->getResubcategories($examBoard->category_id, $examBoard->subcategory_id);

        return [
            'resource' => $boardResource,
            'categories' => $this->categoryRepo->activeCategories(),
            'subCategories' => $subCategories,
            'boards' => $boards,
            'parents' => $this->getParents($examBoard->id),
            'examBoard' => $examBoard,
            'resourceTypes' => $this->resourceTypes(),
            'difficulties' => $this->difficulties(),
        ];
    }

    public function resourceTypes(): array
    {
        return ResourceType::options();
    }

    public function difficulties(): array
    {
        return DifficultyType::options();
    }
}
