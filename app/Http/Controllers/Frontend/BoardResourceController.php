<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\IconByuddy;
use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Models\Resubcategory;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ResubcategoryRepositoryInterface;
use App\Repositories\Interfaces\SubcategoryRepositoryInterface;
use Illuminate\Http\Request;

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
        $resubcategorySlug = $request->input('re_s');
        $subcategorySlug = $request->input('sub_s');
        $categorySlug = $request->input('cat_s');

        $categories = $this->categoryRepo->activeCategories("");
        $category = $this->categoryRepo->findByColumns(['slug' => $categorySlug]);
        $subcategories = $this->subcategoryRepo->activeSubcategories($category->id);
        $subcategory = $this->subcategoryRepo->findByColumns(['category_id' => $category->id, 'slug' => $subcategorySlug]);
        $resubcategories = $this->resubcategoryRepo->activeResubcategories($category->id, $subcategory->id);

        $resubcategory = Resubcategory::with(['category', 'subcategory'])
            ->where('category_id', $category->id)
            ->where('subcategory_id', $subcategory->id)
            ->where('slug', $resubcategorySlug)->first();

        $syllabus = $this->boardRepository->getSyllabus($resubcategory->id, 1);

        $icons = IconByuddy::options();

        return view('frontend.board-resource.index')->with([
            'examBoard' =>  $resubcategory,
            'data' => [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'resubcategories' => $resubcategories,
                'selectedCategory' => $category->id,
                'selectedSubcategory' => $subcategory->id,
                'selectedResubcategory' => $resubcategory->id
            ],
            'syllabus' => $syllabus,
            'icons' => $icons,
        ]);
    }

    public function getType(string $type)
    {
        $typeCase = ResourceType::fromSlug($type);

//        $resources = BoardResource::query()->with([
//            'children.children.files',
//            'children.files',
//            'files',
//        ])->where('resource_type', $typeCase->value)->get();

        $resourceFilter = fn ($q) => $q
            ->where('resource_type', $typeCase->value);

        $tree = Resubcategory::query()
            ->where('is_active', true)
            ->whereHas('boardResources', $resourceFilter) // skip boards with no resources
            ->with([
                'category',
                'subcategory',
                'boardResources' => fn ($q) => $resourceFilter($q)->with([
                    'children.children.files',
                    'children.files',
                    'files',
                ]),
            ])
            ->get()
            ->groupBy([
                fn ($board) => $board->category->category_name,    // e.g. "A Level"
                fn ($board) => $board->subcategory->subcategory_name, // e.g. "Maths"
            ]);

        return view('frontend.board-resource.typed-view')->with([
            'resources' => $tree,
        ]);
    }
}
