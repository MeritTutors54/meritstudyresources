<?php

namespace App\Operations\Backend;

use App\Enums\Status;
use App\Models\AdminActivityLog;
use App\Models\Category;
use App\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Money\Currency;
use Money\Money;
use function PHPUnit\Framework\isFalse;

final class CartActivity
{
    public static function getAllDependantValues($cartItems): array
    {
        $siteSettings = SiteSettings::query()->first();

        $currency = new Currency('GBP');

        $subTotalPriceObject = new Money(0, $currency);

        foreach ($cartItems as $item) {
            $subTotalPriceObject = $subTotalPriceObject->add($item->unit_price);
        }

        $systemDeliveryCharge = new Money(0, $currency);
        if ($siteSettings->delivery_charge != null) {
            $systemDeliveryCharge = $siteSettings->delivery_charge;
        }

        $deliveryChargeObject = $cartItems->isEmpty() ? new Money(0, $currency) : $systemDeliveryCharge;

        $grandTotalPriceObject = $subTotalPriceObject->add($deliveryChargeObject);

        return [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject];
    }


}
