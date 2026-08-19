<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\SEOPage;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
    }

    public function allProducts(Request $request): View
    {
        if (Auth::check()) {
            $this->authorize('viewProductsSection', Auth::user());
        }

        $products = Product::query()
            ->where('status', Status::ACTIVE->value)
            ->orderByDesc('created_at')
            ->paginate(15);

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PRODUCTS->value)
            ->first();

        return view('frontend.product.index-2')
            ->with([
                'defaultSEO' => $defaultSEO,
                'products' => $products
            ]);
    }

    public function details($product_slug)
    {
        if (Auth::check()) {
            $this->authorize('viewProductsSection', Auth::user());
        }

        $product = Product::query()
            ->with([
                'bookVariant' => function ($query) {
                    $query->with(['bookCategory', 'bookSubject']);
                }
            ])
            ->where('slug', $product_slug)
            ->first();

        $relatedProducts = Product::query()
            ->where('status', Status::ACTIVE->value)
            ->orderByDesc('created_at')
            ->where('id', '!=', $product->id)
            ->paginate(15);

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::PRODUCTS->value)
            ->first();

        return view('frontend.product.details-2')
            ->with([
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'defaultSEO' => $defaultSEO
            ]);
    }
}
