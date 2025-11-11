<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Services\MoneyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => MoneyCast::class,
        'subtotal' => MoneyCast::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getMirrorPriceAttribute(): float
    {
        return MoneyService::convertToReadableMoney($this->price);
    }

    public function getMirrorSubtotalAttribute(): float
    {
        return MoneyService::convertToReadableMoney($this->subtotal);
    }
}
