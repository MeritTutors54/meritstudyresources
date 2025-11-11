<?php

namespace App\Models;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\RoundingMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function getUnitPriceAttribute()
    {
        $productPrice = !empty($this->product->mirror_discount) ? $this->product->discount_price : $this->product->regular_price;

        return $productPrice->multiply($this->quantity, Money::ROUND_HALF_UP);
    }

    public function getTotalAttribute(): string
    {
        $currencies = new ISOCurrencies();
        $formatter  = new DecimalMoneyFormatter($currencies);

        return $formatter->format($this->unit_price); // "853.00"
    }



    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
