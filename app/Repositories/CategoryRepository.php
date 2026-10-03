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

    public function activeCategories(?string $sub)
    {

        // Always active subs; filter by name only when a sub was passed
        $subFilter = function ($q) use ($sub) {
            $q->where('is_active', 1)
                ->when($sub, fn ($q) => $q->where('slug', $sub));
        };

        return Category::query()
            ->where('is_active', 1)
            ->when($sub, fn ($q) => $q->whereHas('subCategories', $subFilter))
            ->with([
                'subCategories' => $subFilter,
                'subCategories.resubcategories.pastPapers',
            ])
            ->orderBy('category_name')
            ->get();
    }
}
