<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ResubcategoryRepositoryInterface;
use App\Repositories\Interfaces\SubcategoryRepositoryInterface;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct(
        protected ResubcategoryRepositoryInterface $resubcategories,
        protected SubcategoryRepositoryInterface $subcategories,
        protected CategoryRepositoryInterface $categories,
    )
    {

    }
    public function getRedirectRoute($info)
    {
        $parts = explode('-', $info);

        [$catId, $subCatId, $reSubCatId] = $parts;

        $category = $this->categories->find($catId);
        $subcategory = $this->subcategories->find($subCatId);
        $resubcategory = $this->resubcategories->find($reSubCatId);

        return to_route('past.papers.details', [$category->slug, $subcategory->slug, $resubcategory->slug]);

    }

}
