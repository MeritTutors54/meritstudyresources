<?php

namespace App\Repositories;

use App\Models\SubscriptionPlan;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;

class SubscriptionPlanRepository extends BaseRepository implements SubscriptionPlanRepositoryInterface
{
    public function __construct(SubscriptionPlan $plan)
    {
        parent::__construct($plan);
    }
}
