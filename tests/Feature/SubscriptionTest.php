<?php


use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{

    protected function mockStripe(): void
    {
        // Mock Stripe client
        $stripe = \Mockery::mock('alias:Stripe\Stripe');
        $stripe->shouldReceive('setApiKey');

        // Mock customer creation
        $customer = \Mockery::mock('Stripe\Customer');
        $customer->id = 'cus_test123';
        $customer->shouldReceive('update')->andReturn($customer);

        $stripe->customers = \Mockery::mock();
        $stripe->customers->shouldReceive('create')->andReturn($customer);

        // Mock payment method
        $paymentMethod = \Mockery::mock('Stripe\PaymentMethod');
        $paymentMethod->id = 'pm_test123';

        $stripe->paymentMethods = \Mockery::mock();
        $stripe->paymentMethods->shouldReceive('retrieve')->andReturn($paymentMethod);
        $stripe->paymentMethods->shouldReceive('attach')->andReturn($paymentMethod);

        // Mock subscription creation
        $subscription = \Mockery::mock('Stripe\Subscription');
        $subscription->id = 'sub_test123';
        $subscription->status = 'active';
        $subscription->current_period_end = now()->addMonth()->timestamp;

        $stripe->subscriptions = \Mockery::mock();
        $stripe->subscriptions->shouldReceive('create')->andReturn($subscription);

        // Mock setup intent for checkout page
        $setupIntent = \Mockery::mock('Stripe\SetupIntent');
        $setupIntent->client_secret = 'si_test123';

        $stripe->setupIntents = \Mockery::mock();
        $stripe->setupIntents->shouldReceive('create')->andReturn($setupIntent);
    }

    public function test_user_purchase_student_subscription(): void
    {
        $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
        ]);

        $this->assertAuthenticated();
        $user = auth()->user();
        $this->assertAuthenticatedAs($user);

        $plan = SubscriptionPlan::query()
            ->where('type', SubscriptionType::STUDENT->value)
            ->where('duration', SubscriptionDuration::MONTHLY->value)
            ->first();

        $checkResponse = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->get('/check-packs?q=' . $plan->slug);


        if ($checkResponse->getStatusCode() === 200) {
            if($checkResponse->decodeResponseJson()['type'] === 'success') {
                $tokenOrPm = 'pm_card_visa';
                $user->createOrGetStripeCustomer();
                $subscription = $user->newSubscription('default', $plan->stripe_price_id)  // your “student” price
                ->create($tokenOrPm);

                $subscription->plan_id = $plan->id;
                $subscription->save();
            }
        }
    }

    public function test_user_student_another_purchase_subscription_while_subscribed(): void
    {
        $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
        ]);

        $this->assertAuthenticated();
        $user = auth()->user();
        $this->assertAuthenticatedAs($user);

        $plan = SubscriptionPlan::query()
            ->where('type', SubscriptionType::STUDENT->value)
            ->where('duration', SubscriptionDuration::YEARLY->value)
            ->first();

        $checkResponse = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->get('/check-packs?q=' . $plan->slug);

        $checkResponse->assertStatus(200);
        $checkResponse->assertJsonPath('type', 'error');
    }

}
