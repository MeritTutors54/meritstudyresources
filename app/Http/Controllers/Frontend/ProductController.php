<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ResourceType;
use App\Enums\SEOPage;
use App\Enums\Statement;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\MeritResource;
use App\Models\Product;
use App\Models\Seo;
use App\Operations\Frontend\DeviceActivity;
use App\Operations\Frontend\DownloadHistoryActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Laravel\Cashier\Subscription;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        return view('frontend.product.index')
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

        $buildInKeywords = $product->name
            . ',' . $product->bookVariant->name . ', '
            . $product->bookVariant->bookSubject->name . ', '
            . $product->bookVariant->bookCategory->name;

       $seo['meta_keywords'] = !empty($defaultSEO) ? $defaultSEO->meta_keyword . ', ' . $buildInKeywords : $buildInKeywords;
       $seo['meta_author'] = $defaultSEO->meta_author ?? '';
       $seo['meta_description'] = !empty($defaultSEO) ? $defaultSEO->meta_description . ', ' . $product->description : $product->description;

        return view('frontend.product.details')
            ->with([
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'seo' => $seo
            ]);

    }
}
