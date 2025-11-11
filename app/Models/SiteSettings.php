<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Services\MoneyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Money\Currency;
use Money\Money;

class SiteSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'fax',
        'delivery_charge',
        'white_logo',
        'dark_logo',
        'site_logo',
        'site_favicon',
    ];

    protected $casts = [
        'delivery_charge' => MoneyCast::class,
    ];

    public function getMirrorDeliveryAttribute(): float
    {
        $currency = new Currency('GBP');

        return MoneyService::convertToReadableMoney($this->delivery_charge ?? new Money(0, $currency));
    }

}
