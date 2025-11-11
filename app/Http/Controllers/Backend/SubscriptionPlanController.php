<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateSubscriptionPlanRequest;
use App\Models\AdminActivityLog;
use App\Models\Category;
use App\Models\SubscriptionPlan;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewSubscriptionPlan', Auth::user());

        $allPlans = SubscriptionPlan::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.subscription.index')
            ->with([
                'allPlans' => $allPlans
            ]);
    }


    public function edit(SubscriptionPlan $subscription_plan): View
    {
        $this->authorize('updateSubscriptionPlan', Auth::user());

        $statuses = Status::cases();
        $durations = SubscriptionDuration::cases();
        $types = SubscriptionType::cases();

        return view('backend.subscription.form')
            ->with([
                'subscription_plan' => $subscription_plan,
                'statuses' => $statuses,
                'durations' => $durations,
                'types' => $types
            ]);
    }

    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $this->authorize('updateSubscriptionPlan', Auth::user());

        $notification = [
            'message' => '',
            'alert-type' => '',
        ];

        $log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Category',
            'old_data' => json_encode($subscriptionPlan->toArray()),
        ];

        DB::beginTransaction();

        try {
            $subscriptionPlan->update($request->all());
            AdminActivity::track($log, $subscriptionPlan);

            $notification['message'] = 'Subscription plan has been updated.';
            $notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notification['message'] = $e->getMessage();
            $notification['alert-type'] = 'error';
        }

        return to_route('admin.subscription-plans.index')
            ->with($notification['alert-type'], $notification['message']);
    }
}
