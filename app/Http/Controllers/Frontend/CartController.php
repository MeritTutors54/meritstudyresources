<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\SiteSettings;
use App\Operations\Backend\CartActivity;
use App\Services\MoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Money\Currency;
use Money\Money;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        if (Auth::check()) {
            $this->authorize('viewProductsSection', Auth::user());
        }

        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->get();

        [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject] = CartActivity::getAllDependantValues($cartItems);

        $subTotalPrice = MoneyService::convertToReadableMoney($subTotalPriceObject);
        $grandTotalPrice = MoneyService::convertToReadableMoney($grandTotalPriceObject);
        $deliveryCharge = MoneyService::convertToReadableMoney($deliveryChargeObject);

        return view('frontend.cart.index-2')
            ->with([
                'cartItems' => $cartItems,
                'subTotalPrice' => $subTotalPrice,
                'grandTotalPrice' => $grandTotalPrice,
                'deliveryCharge' => $deliveryCharge,
            ]);
    }
}
