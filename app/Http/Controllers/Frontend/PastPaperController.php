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

        $mode = 1; // Reserved for future use
        $queryValue = mb_strtolower((string) $request->input('q', ''));

        $categories = $this->getData($queryValue, $mode);
        $resubcategories = null;
        $pastPapers = null;
        $params = $this->buildParams($categorySlug, $subcategorySlug, $resubSlug);

        if (filled($categorySlug) && filled($subcategorySlug)) {
            $categoriesQuery = $this->buildCategorySubcategoryQuery(
                $categorySlug,
                $subcategorySlug,
                $queryValue
            );

            $categoriesCollection = $categoriesQuery->get();

            // If search returns nothing, fall back to full list
            if (filled($queryValue) && ! $this->hasResubcategoryMatches($categoriesCollection)) {
                $categoriesCollection = $this->buildCategorySubcategoryQuery(
                    $categorySlug,
                    $subcategorySlug,
                    null
                )->get();
            }

            $categories = $categoriesCollection->toArray();
            $resubcategories = $categories;
        }

        if (filled($categorySlug) && filled($subcategorySlug) && filled($resubSlug)) {
            $pastPapers = $this->getPastPaperTitles(
                $categorySlug,
                $subcategorySlug,
                $resubSlug,
                $queryValue
            );
        }

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PAST_PAPER->value)
            ->first();

        return view('frontend.past-papers.index')->with([
            'q' => $queryValue,
            'params' => $params,
            'categories' => $categories,
            'pastPapers' => $pastPapers,
            'resubcategories' => $resubcategories,
            'mode' => $mode,
            'defaultSEO' => $defaultSEO,
            'results' => null,
        ]);
    }

    public function viewPDF(int $id, mixed $type)
    {
        $pastPaper = PastPaper::query()->findOrFail($id);

        $fileName = data_get($pastPaper, $type);

        if (blank($fileName)) {
            abort(404, 'File not found.');
        }

        $path = public_path("uploads/pastpaper/{$fileName}");

        if (! file_exists($path)) {
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

        $link = route('pdf.view', [
            'id' => $segments[0],
            'type' => $segments[1],
        ]);

        return view('frontend.past-papers.secret_view')->with([
            'link' => $link,
        ]);
    }

    public function getData(string $queryValue, int $mode)
    {
        $categories = Category::query()
            ->with([
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
                        ->with([
                            'resubcategories' => function ($resubQuery) use ($queryValue) {
                                $resubQuery->when($queryValue, function ($q) use ($queryValue) {
                                    $q->where(function ($orQuery) use ($queryValue) {
                                        $orQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                            ->orWhereHas('pastPapers', function ($paperQuery) use ($queryValue) {
                                                $paperQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                                    $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                                });
                                            })
                                            ->orWhereHas('subcategory', function ($subQuery) use ($queryValue) {
                                                $subQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
                                            });
                                    });
                                })
                                    ->with([
                                        'pastPapers' => function ($paperQuery) use ($queryValue) {
                                            $paperQuery->when($queryValue, function ($q) use ($queryValue) {
                                                $q->where(function ($orQuery) use ($queryValue) {
                                                    $orQuery->whereHas('series', function ($seriesQuery) use ($queryValue) {
                                                        $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                                                    })
                                                        ->orWhereHas('resubcategory_model', function ($resubQuery) use ($queryValue) {
                                                            $resubQuery->whereRaw('LOWER(resubcategory_name) LIKE ?', ["%{$queryValue}%"])
                                                                ->orWhereHas('subcategory', function ($subQuery) use ($queryValue) {
                                                                    $subQuery->whereRaw('LOWER(subcategory_name) LIKE ?', ["%{$queryValue}%"]);
                                                                });
                                                        });
                                                });
                                            })
                                                ->with([
                                                    'series' => function ($seriesQuery) {
                                                        $seriesQuery->orderBy('name');
                                                    }
                                                ]);
                                        }
                                    ])
                                    ->orderBy('resubcategory_name');
                            }
                        ])
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
    }

    private function buildCategorySubcategoryQuery(
        string $categorySlug,
        string $subcategorySlug,
        ?string $search = null
    ) {
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
                            },
                        ]);
                },
            ]);
    }

    private function hasResubcategoryMatches($categories): bool
    {
        return $categories->contains(function ($category) {
            return $category->subcategories->contains(function ($subcategory) {
                return $subcategory->resubcategories->isNotEmpty();
            });
        });
    }

    private function getPastPaperTitles(
        string $categorySlug,
        string $subcategorySlug,
        string $resubSlug,
        string $queryValue
    ): array {
        $baseQuery = PastPaper::query()
            ->with([
                'series' => function ($seriesQuery) use ($queryValue) {
                    $seriesQuery->when(filled($queryValue), function ($q) use ($queryValue) {
                        $q->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                    })->orderBy('name');
                },
            ])
            ->whereHas('category_model', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->whereHas('subcategory_model', function ($query) use ($subcategorySlug) {
                $query->where('slug', $subcategorySlug);
            })
            ->whereHas('resubcategory_model', function ($query) use ($resubSlug) {
                $query->where('slug', $resubSlug);
            });

        $filteredQuery = (clone $baseQuery)
            ->when(filled($queryValue), function ($query) use ($queryValue) {
                $query->whereHas('series', function ($seriesQuery) use ($queryValue) {
                    $seriesQuery->whereRaw('LOWER(name) LIKE ?', ["%{$queryValue}%"]);
                });
            });

        $pastPapers = $filteredQuery->get();

        // Fallback if search has no matches
        if (filled($queryValue) && $pastPapers->isEmpty()) {
            $pastPapers = $baseQuery->get();
        }

        return $pastPapers
            ->pluck('title')
            ->unique()
            ->values()
            ->toArray();
    }

    private function buildParams(
        ?string $categorySlug,
        ?string $subcategorySlug,
        ?string $resubSlug
    ): array {
        $params = [];

        $params['category'] = Category::query()
            ->where('slug', $categorySlug)
            ->select(['id', 'category_name', 'slug'])
            ->first()
            ?->toArray();

        if (! empty($params['category'])) {
            $params['subcategory'] = SubCategory::query()
                ->where('slug', $subcategorySlug)
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->with([
                    'resubcategories' => function ($query) {
                        $query->select(['id', 'subcategory_id', 'resubcategory_name', 'slug', 'unit_code']);
                    },
                ])
                ->select(['id', 'subcategory_name', 'slug'])
                ->first()
                ?->toArray();
        }

        if (! empty($params['category']) && ! empty($params['subcategory'])) {
            $params['resubcategory'] = Resubcategory::query()
                ->where('slug', $resubSlug)
                ->whereHas('category', function ($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->whereHas('subcategory', function ($query) use ($subcategorySlug) {
                    $query->where('slug', $subcategorySlug);
                })
                ->select(['id', 'resubcategory_name', 'slug', 'unit_code'])
                ->first()
                ?->toArray();
        }

        return $params;
    }
}
