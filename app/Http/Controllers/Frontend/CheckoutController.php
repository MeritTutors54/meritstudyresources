<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\EmailType;
use App\Enums\Status;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Events\SubscribeEvent;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\SubscriptionPlan;
use App\Operations\Backend\CartActivity;
use App\Services\MoneyService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Subscription;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Request $request): RedirectResponse|View
    {
        $cartItems = Cart::query()
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return to_route('view.cart')
                ->with('error', 'Your cart is empty.');
        }

        [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject] = CartActivity::getAllDependantValues($cartItems);

        $subTotalPrice = MoneyService::convertToReadableMoney($subTotalPriceObject);
        $grandTotalPrice = MoneyService::convertToReadableMoney($grandTotalPriceObject);
        $deliveryCharge = MoneyService::convertToReadableMoney($deliveryChargeObject);

        return view('frontend.checkout.index-2')
            ->with([
                'cartItems' => $cartItems,
                'subTotalPrice' => $subTotalPrice,
                'grandTotalPrice' => $grandTotalPrice,
                'deliveryCharge' => $deliveryCharge,
            ]);
    }
}
