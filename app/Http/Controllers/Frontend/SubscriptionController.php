<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\EmailType;
use App\Enums\Status;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Events\SubscribeEvent;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
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

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Request $request): RedirectResponse|View
    {
        $q = $request->query('q');

        $subscriptionPlan = SubscriptionPlan::query()
            ->where('slug', $q)
            ->where('status', Status::ACTIVE->value)
            ->first();

        $user = $request->user();

        return view('frontend.checkout.subscription-checkout')
            ->with([
                'subscriptionPlan' => $subscriptionPlan,
                'intent' => $user->createSetupIntent(),
                'stripe_key' => Config::get('cashier.key'),
            ]);
    }

    /**
     * @throws ValidationException
     */
    public function subscribe(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'stripe_token' => 'required',
        ]);

        $plan = SubscriptionPlan::query()
            ->where('id', $request->plan_id ?? '')
            ->where('status', Status::ACTIVE->value)
            ->first();

        $stripeSubscription = $request->user()->newSubscription('default', $plan->stripe_price_id)
            ->create($request->stripe_token ?? '');

        $stripeSubscription->plan_id = $plan->id;
        $stripeSubscription->save();

//        SubscribeEvent::dispatch(Auth::user()->email ?? '', EmailType::NEW_SUBSCRIPTION->value);

        return to_route('user.dashboard')
            ->with('success', 'You have successfully subscribed.');
    }

    public function pause(Subscription $subscription): RedirectResponse
    {
        $subscription->cancel();

        SubscribeEvent::dispatch(Auth::user()->email ?? '', EmailType::PAUSE_SUBSCRIBER->value);

        return to_route('user.subscription.list')
            ->with('success', 'You have successfully paused the subscription.');
    }

    public function resume(Subscription $subscription): RedirectResponse
    {
        $subscription->resume();

        SubscribeEvent::dispatch(Auth::user()->email ?? '', EmailType::RESUME_SUBSCRIBER->value);

        return to_route('user.subscription.list')
            ->with('success', 'You have successfully resumed the subscription.');
    }

    public function cancel(Subscription $subscription): RedirectResponse
    {
        if ($subscription->user?->downloadHistories->count() > 0) {
            $subscription->user->downloadHistories()->update([
                'status' => 0, // Example field to update
                'updated_at' => now(),
            ]);
        }

        $subscription->cancelNow();

//        SubscribeEvent::dispatch(Auth::user()->email ?? '', EmailType::CANCEL_SUBSCRIBER->value);

        return to_route('user.subscription.list')
            ->with('success', 'You have successfully cancelled the subscription.');
    }
}
