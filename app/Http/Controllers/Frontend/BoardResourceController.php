<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\IconByuddy;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Resubcategory;
use App\Models\SiteSettings;
use App\Operations\Backend\CartActivity;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ResubcategoryRepositoryInterface;
use App\Repositories\Interfaces\SubcategoryRepositoryInterface;
use App\Services\MoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BoardResourceController extends Controller
{
    public function __construct(
        protected BoardResourceRepositoryInterface $boardRepository,
        protected CategoryRepositoryInterface $categoryRepo,
        protected SubcategoryRepositoryInterface $subcategoryRepo,
        protected ResubcategoryRepositoryInterface $resubcategoryRepo,
    ) {}

    public function index(Request $request)
    {
        $resubcategoryId = $request->input('re_id');
        $subcategoryId = $request->input('sub_id');
        $categoryId = $request->input('cat_id');

        $categoires = $this->categoryRepo->activeCategories();
        $subcategories = $this->subcategoryRepo->activeSubcategories($categoryId);
        $resubcategories = $this->resubcategoryRepo->activeResubcategories($categoryId, $subcategoryId);

        $resubcategory = Resubcategory::with(['category', 'subcategory'])
            ->where('id', $resubcategoryId)->first();

        $syllabus = $this->boardRepository->getSyllabus($resubcategoryId, 1);

        $icons = IconByuddy::options();

        return view('frontend.board-resource.index')->with([
            'examBoard' =>  $resubcategory,
            'data' => [
                'categories' => $categoires,
                'subcategories' => $subcategories,
                'resubcategories' => $resubcategories,
                'selectedCategory' => $categoryId,
                'selectedSubcategory' => $subcategoryId, 
                'selectedResubcategory' => $resubcategoryId
            ],
            'syllabus' => $syllabus,
            'icons' => $icons,
        ]);
    }
}
