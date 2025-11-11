<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\OrderStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBookCategoryRequest;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\UpdateBookCategoryRequest;
use App\Models\BookCategory;
use App\Models\Order;
use App\Models\TrackingOrder;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewOrderDetails', Auth::user());

        $orders = Order::query()
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.ecommerce.order.index')
            ->with([
                'orders' => $orders,
            ]);
    }

    public function details(Order $order): View
    {
        $this->authorize('viewOrderDetails', Auth::user());

        $orderStatuses = OrderStatus::cases();

        return view('backend.ecommerce.order.details')
            ->with([
                'order' => $order,
                'orderStatuses' => $orderStatuses,
            ]);
    }

    public function updateTrack(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('updateOrderTracking', Auth::user());

        $request->validate([
            'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
            'remark' => ['nullable', 'string'],
        ]);

        TrackingOrder::query()->create([
            'tracking_number' => $order->tracking_number,
            'order_id' => $order->id,
            'admin_id' => auth()->id(),
            'remarks' => $request->remark,
            'status' => $request->status
        ]);


        return to_route('admin.manage.order.details', [$order])
            ->with('success', 'Order updated successfully.');
    }


}
