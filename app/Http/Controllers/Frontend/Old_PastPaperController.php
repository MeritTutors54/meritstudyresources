<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\SEOPage;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PastPaper;
use App\Models\Resubcategory;
use App\Models\Seo;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class Old_PastPaperController extends Controller
{
    public function __construct()
    {

    }

    public function index(
        Request $request,
                $categorySlug = null,
                $subcategorySlug = null,
                $resubSlug = null,
                $title = null,
    ): View
    {
        if (Auth::check()) {
            $this->authorize('viewPastPaperSection', Auth::user());
        }

        $mode = 0;

        $queryValue = strtolower($request->input('q') ?? '');


        $categories = Category::with(['subcategories' => function ($query) use ($queryValue) {
            if ($queryValue) {
                $query->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"])
                    ->with(['resubcategories' => function ($subQuery) use ($queryValue) {
                        $subQuery->orderBy('resubcategory_name');
                    }])->orderBy('subcategory_name');
            } else {
                $query->with(['resubcategories' => function ($resubQuery) {
                    $resubQuery->orderBy('resubcategory_name');
                }])
                    ->orderBy('subcategory_name');
            }
        }]);

        if ($queryValue) {
            // Only get categories which have at least one matching subcategory or resubcategory
            $categories->whereHas('subcategories', function ($query) use ($queryValue) {
                $query->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
            });
        }

        $categories = $categories->where('is_active', Status::ACTIVE->value)
            ->whereHas('subcategories', function ($query) {
                $query->orderBy('subcategory_name');
            })
            ->orderBy('category_name')
            ->get()->toArray();

        if (!empty($categorySlug) && !empty($subcategorySlug)) {
            $resubcategories = Resubcategory::query()
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })->whereHas('subcategory', function ($query) use ($subcategorySlug) {
                    $query->where('slug', $subcategorySlug);
                })
                ->get();
        }

        if (!empty($categorySlug) && !empty($subcategorySlug) && !empty($resubSlug)) {
            $mode = 1;
            $pastPapers = PastPaper::query()
                ->with(['series'])
                ->whereHas('category_model', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })->whereHas('subcategory_model', function ($query) use ($subcategorySlug) {
                    $query->where('slug', $subcategorySlug);
                })->whereHas('resubcategory_model', function ($query) use ($resubSlug) {
                    $query->where('slug', $resubSlug);
                })
                ->get()
                ->pluck('title')->unique()->values();
        }

//        if (!empty($categorySlug) && !empty($subcategorySlug) && !empty($resubSlug) && !empty($title)) {
//            $mode = 2;
//            $pastPapers = PastPaper::query()
//                ->with(['series'])
//                ->whereHas('category_model', function ($query) use ($categorySlug) {
//                    $query->where('slug', $categorySlug);
//                })->whereHas('subcategory_model', function ($query) use ($subcategorySlug) {
//                    $query->where('slug', $subcategorySlug);
//                })->whereHas('resubcategory_model', function ($query) use ($resubSlug) {
//                    $query->where('slug', $resubSlug);
//                })
//                ->where('title', $title)
//                ->get()
//                ->sortByDesc(function ($paper) {
//                    return strtotime($paper->series->name);
//                })
//                ->groupBy(function ($paper) {
//                    return $paper->series->name;
//                });
//        }

        $params['category'] = Category::query()->where('slug', $categorySlug)->select(['id', 'category_name', 'slug'])->first()?->toArray();
        if (!empty($params['category'])) {
            $params['subcategory'] = SubCategory::query()->where('slug', $subcategorySlug)
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->select(['id', 'subcategory_name', 'slug'])->first()?->toArray();
        }
        if (!empty($params['category']) && !empty($params['subcategory'])) {
            $params['resubcategory'] = Resubcategory::query()->where('slug', $resubSlug)
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->whereHas('subcategory', function ($query) use ($subcategorySlug) {
                    $query->where('slug', $subcategorySlug);
                })
                ->select(['id', 'resubcategory_name', 'slug', 'unit_code'])
                ->first()?->toArray();
        }

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PAST_PAPER->value)
            ->first();

        return view('frontend.past-papers.index')
            ->with([
                'q' => $queryValue,
                'params' => $params ?? null,
                'categories' => $categories ?? null,
                'pastPapers' => $pastPapers ?? null,
                'resubcategories' => $resubcategories ?? null,
                'mode' => $mode,
                'defaultSEO' => $defaultSEO ?? null,
            ]);
    }

    public function viewPDF($id, $type)
    {
        $pastPaper = PastPaper::query()
            ->where('id', $id)->first();

        $path = public_path("uploads/pastpaper/{$pastPaper->$type}"); // Example

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        $fileContent = file_get_contents($path);
        $mimeType = mime_content_type($path);

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="document.pdf"');
    }

    public function secretView($secret)
    {
        $decrypted = Crypt::decryptString($secret);

        $segments = explode('-', $decrypted);

        $link = route('pdf.view', ['id' => $segments[0], 'type' => $segments[1]]);

        return view('frontend.past-papers.secret_view')->with([
            'link' => $link,
        ]);
    }
}
