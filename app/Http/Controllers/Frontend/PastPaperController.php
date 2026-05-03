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

class PastPaperController extends Controller
{
    public function __construct() {}

    public function index(
        Request $request,
        $categorySlug = null,
        $subcategorySlug = null,
        $resubSlug = null,
        $title = null,
    ): View {
        if (Auth::check()) {
            $this->authorize('viewPastPaperSection', Auth::user());
        }

        $mode = 1; // default mode

        $queryValue = strtolower($request->input('q') ?? '');

        $categories = $this->getDataViaMode($mode, $queryValue);

        // For the dropdown filters
        if (!empty($categorySlug) && !empty($subcategorySlug)) {
            // $resubcategories = Category::query()
            //     ->with(['subcategories' => function ($query) use ($subcategorySlug) {
            //         $query->where('slug', $subcategorySlug)
            //             ->with(['resubcategories' => function ($resubQuery) {
            //                 $resubQuery->select(['id', 'subcategory_id', 'resubcategory_name', 'slug', 'unit_code']);
            //             }])
            //             ->select(['id', 'category_id', 'subcategory_name', 'slug']);
            //     }])
            //     ->where('slug', $categorySlug)
            //     ->whereHas('subCategories', function ($query) use ($subcategorySlug) {
            //         $query->where('slug', $subcategorySlug);
            //     })
            //     ->get()->toArray();

            $buildQuery = function (?string $search = null) use ($categorySlug, $subcategorySlug) {
                return Category::query()
                    ->where('slug', $categorySlug)
                    ->whereHas('subcategories', function ($query) use ($subcategorySlug) {
                        $query->where('slug', $subcategorySlug);
                    })
                    ->with([
                        'subcategories' => function ($query) use ($subcategorySlug, $search) {
                            $query->where('slug', $subcategorySlug)
                                ->select(['id', 'category_id', 'subcategory_name', 'slug'])
                                ->with([
                                    'resubcategories' => function ($resubQuery) use ($search) {
                                        $resubQuery->select([
                                            'id',
                                            'subcategory_id',
                                            'resubcategory_name',
                                            'slug',
                                            'unit_code',
                                        ]);

                                        if (filled($search)) {
                                            $resubQuery->whereRaw(
                                                'LOWER(resubcategory_name) LIKE ?',
                                                ['%' . mb_strtolower($search) . '%']
                                            );
                                        }
                                    }
                                ]);
                        }
                    ]);
            };

            $categories = $buildQuery($queryValue)->get();

            // If search was provided but nothing matched, load everything instead
            $hasMatches = $categories->contains(function ($category) {
                return $category->subcategories->contains(function ($subcategory) {
                    return $subcategory->resubcategories->isNotEmpty();
                });
            });

            if (filled($queryValue) && ! $hasMatches) {
                $categories = $buildQuery(null)->get();
            }

            $resubcategories = $categories->toArray();
        }

        if (!empty($categorySlug) && !empty($subcategorySlug) && !empty($resubSlug)) {
            // $mode = 1;
            // $pastPapers = PastPaper::query()
            //     ->with(['series'])
            //     ->whereHas('category_model', function ($query) use ($categorySlug) {
            //         $query->where('slug', $categorySlug);
            //     })->whereHas('subcategory_model', function ($query) use ($subcategorySlug) {
            //         $query->where('slug', $subcategorySlug);
            //     })->whereHas('resubcategory_model', function ($query) use ($resubSlug) {
            //         $query->where('slug', $resubSlug);
            //     })
            //     ->get()
            //     ->pluck('title')->unique()->values();

            if (!empty($categorySlug) && !empty($subcategorySlug) && !empty($resubSlug)) {

                $baseQuery = PastPaper::query()
                    ->with(['series' => function ($seriesQuery) use ($queryValue) {
                        $seriesQuery->when($queryValue, function ($q) use ($queryValue) {
                            $q->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                        })->orderBy('name');
                    }])
                    ->whereHas('category_model', function ($query) use ($categorySlug) {
                        $query->where('slug', $categorySlug);
                    })
                    ->whereHas('subcategory_model', function ($query) use ($subcategorySlug) {
                        $query->where('slug', $subcategorySlug);
                    })
                    ->whereHas('resubcategory_model', function ($query) use ($resubSlug) {
                        $query->where('slug', $resubSlug);
                    });

                // Clone for filtering with queryValue
                $filteredQuery = (clone $baseQuery)
                    ->when($queryValue, function ($query) use ($queryValue) {
                        $query->whereHas('series', function ($seriesQuery) use ($queryValue) {
                            $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                        });
                    });

                $pastPapers = $filteredQuery->get();

                // 🔁 Fallback if no results
                if ($queryValue && $pastPapers->isEmpty()) {
                    $pastPapers = $baseQuery->get();
                }

                // Final transformation
                $pastPapers = $pastPapers->pluck('title')->unique()->values();

                // dd($pastPapers);
            }
        }


        $params['category'] = Category::query()->where('slug', $categorySlug)->select(['id', 'category_name', 'slug'])->first()?->toArray();
        if (!empty($params['category'])) {
            $params['subcategory'] = SubCategory::query()
                ->where('slug', $subcategorySlug)
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->with(['resubcategories' => function ($query) {
                    $query->select(['id', 'subcategory_id', 'resubcategory_name', 'slug', 'unit_code']);
                }])
                ->select(['id', 'subcategory_name', 'slug'])
                ->first()?->toArray();
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
                'results' => $results ?? null,
            ]);
    }

    public function viewPDF(int $id, mixed $type)
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

    public function secretView(string $secret)
    {
        $decrypted = Crypt::decryptString($secret);

        $segments = explode('-', $decrypted);

        $link = route('pdf.view', ['id' => $segments[0], 'type' => $segments[1]]);

        return view('frontend.past-papers.secret_view')->with([
            'link' => $link,
        ]);
    }

    public function getDataViaMode(int $mode, string $queryValue)
    {

        $categories = Category::with([
            'subcategories' => function ($query) use ($queryValue) {
                $query->when($queryValue, function ($q) use ($queryValue) {
                    $q->where(function ($orQuery) use ($queryValue) {
                        $orQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"])
                            ->orWhereHas('resubcategories', function ($resubQuery) use ($queryValue) {
                                $resubQuery->where(function ($orResubQuery) use ($queryValue) {
                                    $orResubQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                        ->orWhereHas('pastPapers', function ($paperQuery) use ($queryValue) {
                                            $paperQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                                $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                            });
                                        });
                                });
                            });
                    });
                })
                    ->with(['resubcategories' => function ($resubQuery) use ($queryValue) {
                        $resubQuery->when($queryValue, function ($q) use ($queryValue) {
                            // If the subcategory name itself matches, load ALL resubcategories unfiltered
                            // If not, only load resubcategories that match deeper
                            $q->where(function ($orQuery) use ($queryValue) {
                                $orQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                    ->orWhereHas('pastPapers', function ($paperQuery) use ($queryValue) {
                                        $paperQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                            $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                        });
                                    })
                                    // Key fix: also include ALL resubcategories whose parent subcategory name matches
                                    ->orWhereHas('subcategory', function ($subQuery) use ($queryValue) {
                                        $subQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
                                    });
                            });
                        })
                            ->with(['pastPapers' => function ($paperQuery) use ($queryValue) {
                                $paperQuery->when($queryValue, function ($q) use ($queryValue) {
                                    $q->where(function ($orQuery) use ($queryValue) {
                                        $orQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                            $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                        })
                                            // Also load all past papers if parent resubcategory or subcategory matches
                                            ->orWhereHas('resubcategory_model', function ($resubQuery) use ($queryValue) {
                                                $resubQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                                    ->orWhereHas('subcategory', function ($subQuery) use ($queryValue) {
                                                        $subQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
                                                    });
                                            });
                                    });
                                })
                                    ->with(['series' => function ($seriesQuery) use ($queryValue) {
                                        $seriesQuery->orderBy('name');
                                    }]);
                            }])
                            ->orderBy('resubcategory_name');
                    }])
                    ->orderBy('subcategory_name');
            }
        ])
            ->where('is_active', Status::ACTIVE->value)
            ->when($queryValue, function ($query) use ($queryValue) {
                $query->whereHas('subcategories', function ($q) use ($queryValue) {
                    $q->where(function ($orQuery) use ($queryValue) {
                        $orQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"])
                            ->orWhereHas('resubcategories', function ($resubQuery) use ($queryValue) {
                                $resubQuery->where(function ($orResubQuery) use ($queryValue) {
                                    $orResubQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                        ->orWhereHas('pastPapers', function ($paperQuery) use ($queryValue) {
                                            $paperQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                                $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                            });
                                        });
                                });
                            });
                    });
                });
            })
            ->whereHas('subcategories')
            ->orderBy('category_name')
            ->get()
            ->toArray();

        return $categories;



        // $categories = Category::with(['subcategories' => function ($query) use ($queryValue) {
        //     if ($queryValue) {
        //         $query->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"])
        //             ->with(['resubcategories' => function ($subQuery) {
        //                 $subQuery->orderBy('resubcategory_name');
        //             }])->orderBy('subcategory_name');
        //     } else {
        //         $query->with(['resubcategories' => function ($resubQuery) {
        //             $resubQuery->orderBy('resubcategory_name');
        //         }])
        //             ->orderBy('subcategory_name');
        //     }
        // }]);

        // if ($queryValue) {
        //     // Only get categories which have at least one matching subcategory or resubcategory
        //     $categories->whereHas('subcategories', function ($query) use ($queryValue) {
        //         $query->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
        //     });
        // }

        // $categories = $categories->where('is_active', Status::ACTIVE->value)
        //     ->whereHas('subcategories', function ($query) {
        //         $query->orderBy('subcategory_name');
        //     })
        //     ->orderBy('category_name')
        //     ->get()->toArray();

        // return $categories;
    }
}
