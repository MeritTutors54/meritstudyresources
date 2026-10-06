<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class Product extends Model
{
    use HasFactory, softDeletes;

protected $fillable = [
    'book_variant_id',
    'title',
    'year_group_id',
    'slug',
    'sku',
    'description',
    'image',
    'regular_price',
    'discount_price',
    'discount_percentage',
    'base_currency',
    'search_text',
    'status',
    'amazon_link',
    'subjects',
    'solution_types',
    'product_image',
    'product_soluition',
];

protected $casts = [
    'solution_types' => 'array',
    'product_image' => 'array',
];
    public function getMirrorPriceAttribute(): ?string
    {
        if (!$this->regular_price) {
            return null;                          // or return '0.00'
        }

        $currencies = new ISOCurrencies();
        $formatter  = new DecimalMoneyFormatter($currencies);

        return $formatter->format($this->regular_price); // "853.00"
    }

    public function getMirrorDiscountAttribute()
    {
        if (!$this->discount_price) {
            return null;                          // or return '0.00'
        }

        $currencies = new ISOCurrencies();
        $formatter  = new DecimalMoneyFormatter($currencies);

        return $formatter->format($this->discount_price); // "853.00"
    }

    public function bookVariant(): BelongsTo
    {
        return $this->belongsTo(BookVariant::class);
    }

    public function getSampleImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getActualDiscountAttribute(): float
    {
        $discountPercentage = (($this->mirror_price - $this->mirror_discount) / $this->mirror_price) * 100;

        return round($discountPercentage, 2);
    }

    public function getMirrorActualPriceAttribute(): float
    {
        $currencies = new ISOCurrencies();
        $formatter  = new DecimalMoneyFormatter($currencies);

        if (!empty($this->discount_price)) {
            return $formatter->format($this->discount_price);
        }

        return $formatter->format($this->price);
    }

    public function yearGroup(): BelongsTo
    {
        return $this->belongsTo(YearGroup::class, 'year_group_id', 'id');
    }
}
