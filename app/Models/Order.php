<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Services\MoneyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "billing_name",
        "billing_phone",
        "billing_alternative_phone",
        "billing_address",
        "billing_city",
        "billing_state",
        "billing_post_code",
        "remarks",
        "coupon_code",
        "invoice_number",
        "user_id",
        "tracking_number",
        "base_currency",
        "total_price",
        "discount_price",
        'subtotal_price',
        'delivery_cost',
        'stripe_charge_id',
        'stripe_refund_id',
        "status",
    ];

    protected $casts = [
        "total_price" => MoneyCast::class,
        "discount_price" => MoneyCast::class,
        "subtotal_price" => MoneyCast::class,
        "delivery_cost" => MoneyCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function trackReports(): HasMany
    {
        return $this->hasMany(TrackingOrder::class);
    }

    public function getMirrorTotalAttribute(): float
    {
        return MoneyService::convertToReadableMoney($this->total_price);
    }

    public function getMirrorDiscountAttribute(): float
    {
        if (empty($this->discount_price)) {
            return 00.00;
        }

        return MoneyService::convertToReadableMoney($this->discount_price);
    }

    public function getMirrorSubtotalAttribute(): float
    {
        return MoneyService::convertToReadableMoney($this->subtotal_price);
    }

    public function getMirrorDeliveryAttribute(): float
    {
        return MoneyService::convertToReadableMoney($this->delivery_cost);
    }

    public function getLatestTrackingStatusAttribute()
    {
        $latestTrack = $this->trackReports()->latest()->first();

        return $latestTrack ? $latestTrack->status : null;
    }

}
