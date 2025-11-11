<?php

namespace App\Http\Controllers\Backend\Coupon;

use App\Enums\DiscountType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCouponRequest;
use App\Models\Coupon;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CouponController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewCoupon', Auth::user());

        $coupons = Coupon::all();

        return view('backend.coupon.index')
            ->with([
                'coupons' => $coupons
            ]);
    }

    public function create(): View
    {
        $this->authorize('createCoupon', Auth::user());

        $statuses = Status::cases();

        $discountTypes = DiscountType::cases();

        return view('backend.coupon.form')
            ->with([
                'statuses' => $statuses,
                'discountTypes' => $discountTypes
            ]);
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $this->authorize('createCoupon', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Coupon',
        ];

        DB::beginTransaction();
        try {
            $coupon = Coupon::query()->create($request->all());
            AdminActivity::track($this->log, $coupon);

            $this->notification['alert_type'] = 'success';
            $this->notification['message'] = 'Coupon has been created';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['alert_type'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.coupons.index')
            ->with($this->notification['alert_type'], $this->notification['message']);
    }

    public function edit(Coupon $coupon): View
    {
        $this->authorize('updateCoupon', $coupon);

        $statuses = Status::cases();
        $discountTypes = DiscountType::cases();

        return view('backend.coupon.form')
            ->with([
                'coupon' => $coupon,
                'statuses' => $statuses,
                'discountTypes' => $discountTypes
            ]);
    }

    public function update(StoreCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $this->authorize('updateCoupon', $coupon);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Coupon',
            'old_data' => json_encode($coupon->toArray()),
        ];

        DB::beginTransaction();
        try {
            $coupon->update($request->all());
            AdminActivity::track($this->log, $coupon);

            $this->notification['alert_type'] = 'success';
            $this->notification['message'] = 'Coupon has been updated';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['alert_type'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.coupons.index')
            ->with($this->notification['alert_type'], $this->notification['message']);
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $this->authorize('deleteCoupon', $coupon);

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Coupon',
            'old_data' => json_encode($coupon->toArray()),
        ];

        DB::beginTransaction();
        try {

            //ToDo : need to check the coupon is used or not

            $coupon->delete();
            AdminActivity::track($this->log, $coupon);

            $this->notification['alert_type'] = 'success';
            $this->notification['message'] = 'Coupon has been deleted';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['alert_type'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.coupons.index')
            ->with($this->notification['alert_type'], $this->notification['message']);
    }
}
