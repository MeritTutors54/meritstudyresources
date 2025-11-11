<?php

namespace App\Operations\Backend;

use App\Enums\Status;
use App\Models\AdminActivityLog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

final class StripeProductActivity
{

    public static function getStripeProductPrice(
        string $productName,
        string $description,
        int    $amount): string
    {
        $product = self::createStripeProduct($productName, $description);
        $price = self::createPriceOfStripeProduct($product->id, $amount);




        return $price->id;
    }

    protected static function createPriceOfStripeProduct(
        string $productId,
        int    $amount): \Stripe\Price
    {
        $currentCurrency = env('CASHIER_CURRENCY');

        return Cashier::stripe()->prices->create([
            'product' => $productId,
            'unit_amount' => $amount, // $1200.00
            'currency' => $currentCurrency,
        ]);
    }

    protected static function createStripeProduct(
        string $productName,
        string $description): \Stripe\Product
    {
        // Create stipe product
        return Cashier::stripe()->products->create([
            'name' => $productName,
            'description' => $description,
        ]);
    }


}
