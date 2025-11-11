<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBookCategoryRequest;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\UpdateBookCategoryRequest;
use App\Models\BookCategory;
use App\Models\SiteSettings;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DeliveryChargeController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewDeliveryCharge', Auth::user());

        $siteSettings = SiteSettings::query()->first();

        $view = 'delivery-charge';

        return view('backend.site-settings.form')
            ->with([
                'siteSettings' => $siteSettings,
                'view' => $view,
            ]);
    }



    public function update(Request $request, SiteSettings $delivery_charge): RedirectResponse
    {
        $this->authorize('updateDeliveryCharge', Auth::user());

        $request->validate([
            'delivery_charge' => ['required', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
        ],[
            'delivery_charge.regex' => 'Delivery charge must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
        ]);


        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\SiteSettings',
            'old_data' => json_encode($delivery_charge->toArray()),
        ];

        DB::beginTransaction();

        try {
            $delivery_charge->update([
                'delivery_charge' => $request->delivery_charge ?? 0
            ]);

            AdminActivity::track($this->log, $delivery_charge);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Delivery charge updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.delivery-charge.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
