<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\TrackingOrder;
use App\Operations\Backend\CartActivity;
use App\Operations\Frontend\CouponActivity;
use App\Services\MoneyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $notification = [];
        $order = null;

        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->get();

        [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject] = CartActivity::getAllDependantValues($cartItems);

        // check is there any coupon is active or not
        if (!empty($request->coupon_code)) {
            // Applying coupon
            $couponResult = CouponActivity::applyingCoupon($request->coupon_code, $grandTotalPriceObject);
            if (!is_array($couponResult)) {
                $request->merge([
                    'subtotal_price' => MoneyService::convertToReadableMoney($subTotalPriceObject),
                    'total_price' => MoneyService::convertToReadableMoney($grandTotalPriceObject),
                    'delivery_cost' => MoneyService::convertToReadableMoney($deliveryChargeObject),
                ]);
            } else {
                $currentGrandTotalPriceObject = $grandTotalPriceObject->subtract($couponResult[0]);
                $request->merge([
                    'subtotal_price' => MoneyService::convertToReadableMoney($subTotalPriceObject),
                    'discount_price' => MoneyService::convertToReadableMoney($couponResult[0]),
                    'total_price' => MoneyService::convertToReadableMoney($currentGrandTotalPriceObject),
                    'delivery_cost' => MoneyService::convertToReadableMoney($deliveryChargeObject),
                ]);
            }
        } else {
            $request->merge([
                'subtotal_price' => MoneyService::convertToReadableMoney($subTotalPriceObject),
                'total_price' => MoneyService::convertToReadableMoney($grandTotalPriceObject),
                'delivery_cost' => MoneyService::convertToReadableMoney($deliveryChargeObject),
            ]);
        }

        DB::beginTransaction();
        try {
            $order = Order::query()->create($request->all());

            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ? $item->product->discount_price : $item->product->price;

                OrderItems::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => MoneyService::convertToReadableMoney($price),
                    'subtotal' => MoneyService::convertToReadableMoney($item->unit_price),
                ]);
            }

            $trackOrder = TrackingOrder::query()->create([
                'order_id' => $order->id,
                'tracking_number' => $order->tracking_number,
                'status' => OrderStatus::PENDING->value,
            ]);

            Cart::query()
                ->where('user_id', Auth::id())
                ->delete();

            $notification['type'] = 'success';
            $notification['message'] = 'Your order has in queue. Please complete the payment to place the order.';

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();

            $notification['type'] = 'error';
            $notification['message'] = $exception->getMessage();
        }

       return to_route('user.complete.payment', $order->invoice_number)
           ->with($notification['type'], $notification['message']);
    }

    public function payment(Request $request, $invoice): View | RedirectResponse
    {
        $order = Order::query()
            ->with('items.product')
            ->where('status', PaymentStatus::INCOMPLETE->value)
            ->where('invoice_number', $invoice)->first();

        if (empty($order)) {
            return to_route('user.order.checkout')
                ->with('error', 'Order not found.');
        }

        $payableAmount = MoneyService::convertToReadableMoney($order->total_price);

        $user = request()->user();

        $user->createOrGetStripeCustomer();

        return view('frontend.checkout.payment')
            ->with([
                'payable_amount' => $payableAmount,
                'order' => $order,
                'intent' => $user->createSetupIntent(),
                'stripe_key' => Config::get('cashier.key'),
            ]);
    }

    public function complete(Request $request): RedirectResponse
    {
        $order = Order::query()
            ->with('items.product')
            ->where('status', PaymentStatus::INCOMPLETE->value)
            ->where('id', $request->order_id)->first();

        if (empty($order)) {
            return to_route('user.dashboard')
                ->with('error', 'Order not found.');
        }

        $user = Auth::user(); // Assuming you're charging the currently logged-in user

        DB::beginTransaction();
        try {
            $stripeData = $user->charge(
                $order->total_price->getAmount(), // Amount in cents (e.g., 1000 for $10.00)
                $request->stripe_token, // ID of the payment method (e.g., from Stripe Elements)
                [
                    'description' => 'One-time payment for ' . $order->invoice_number,
                    'currency' => 'gbp', // Or your desired currency
                    'return_url' => route('user.return.payment'),
                ]
            );

            $order->status = PaymentStatus::CONFIRMED->value;
            $order->stripe_charge_id = $stripeData->latest_charge;
            $order->save();

            DB::commit();

            return to_route('user.dashboard')
                ->with('success', 'Payment successful and Order has been placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return to_route('user.dashboard')
                ->with('error', $e->getMessage());
        }
    }

    public function returnPayment(): RedirectResponse
    {
       return to_route('user.dashboard')
           ->with('success', 'Payment successful and Order placed successfully.');
    }

}
