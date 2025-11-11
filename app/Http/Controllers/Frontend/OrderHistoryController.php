<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\SiteSettings;
use App\Models\TrackingOrder;
use App\Operations\Backend\CartActivity;
use App\Services\MoneyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Money\Currency;
use Money\Money;

class OrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $orderHistory = Order::query()
            ->with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.dashboard.order-history.index')
            ->with([
                'orderHistory' => $orderHistory,
            ]);
    }

    public function details($invoice): View
    {
        $order = Order::query()
            ->with('items.product')
            ->where('invoice_number', $invoice)
            ->where('user_id', Auth::id())
            ->first();


        $trackOrder = TrackingOrder::query()
            ->where('order_id', $order->id)
            ->where('tracking_number', $order->tracking_number)
            ->get();

        return view('frontend.dashboard.order-history.details')
            ->with([
                'order' => $order,
                'tracks' => $trackOrder,
            ]);
    }

    public function cancelOrder(Order $order): RedirectResponse
    {
        if ($order->latest_tracking_status != OrderStatus::PENDING->value) {
            return to_route('user.order.history')
                ->with('error', 'Something went wrong while trying to cancel order.');
        }


        $notification = [];
        $stripe = Cashier::stripe();

        DB::beginTransaction();
        try {
            $refund = $stripe->refunds->create([
                'charge' => $order->stripe_charge_id
            ]);

            $order->status  = PaymentStatus::CANCELLED->value;
            $order->stripe_refund_id = $refund->id;
            $order->save();

            TrackingOrder::query()->create([
                'tracking_number' => $order->tracking_number,
                'order_id' => $order->id,
                'status' => OrderStatus::CANCELLED->value,
            ]);

            $notification['type'] = "success";
            $notification['message'] = "Your order has been cancelled.";

            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();

            $notification['type'] = "error";
            $notification['message'] = $e->getMessage();
        }


        return to_route('user.order.history')
            ->with($notification['type'], $notification['message']);
    }
}
