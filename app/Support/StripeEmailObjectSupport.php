<?php

namespace App\Support;

use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionType;

final class StripeEmailObjectSupport
{
    public function organize(mixed $user): array
    {
        $array = [];

        $plan = $user->active_subscription_plan ?? null;

        if (!empty($plan)) {
            $array['details'] = [
                'Total PDF Download Limit : ' . $plan->download_limit,
                'Unlock all resource',
            ];
            if ($plan->type === \App\Enums\SubscriptionType::SCHOOL->value) {
                // Add the user limit to the beginning of the array
                array_unshift($array['details'], 'User Limit : ' . $plan->user_limit);
            }

            $array['user_type'] = strtolower(SubscriptionType::from($plan->type)->name);
            $array['duration'] =  strtolower(SubscriptionDuration::class::from($plan->duration)->name);
            $array['name'] =  strtolower($plan->name);
        }

        return $array;
    }

}
