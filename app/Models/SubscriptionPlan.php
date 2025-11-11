<?php

namespace App\Models;

use App\Enums\SubscriptionDuration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'level',
        'stripe_price_id',
        'user_limit',
        'weekly_limit',
        'download_limit',
        'has_full_access',
        'trial_days',
        'type',
        'duration',
        'status',
    ];


    public function getDurationNameAttribute(): string
    {
        return ucfirst(strtolower(SubscriptionDuration::from($this->duration ?? '')->name));
    }

    public function getTypeNameAttribute(): string
    {
        return  ucfirst(strtolower(\App\Enums\SubscriptionType::from($this->type ?? '')->name));
    }
}
