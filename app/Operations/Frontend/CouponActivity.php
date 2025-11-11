<?php

namespace App\Operations\Frontend;

use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\UserDevice;
use App\Services\MoneyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

final class CouponActivity
{
    public static function applyingCoupon($code, $price = null): array | JsonResponse
    {
        $discountPriceObject = null;
        $msg = '';

        $coupon = Coupon::query()
            ->where('code', 'LIKE BINARY', $code) // Case-sensitive
            ->where('status', Status::ACTIVE->value)
            ->first();

        if (!$coupon) {
            return response()->json([
                'type' => 'error',
                'message' => 'Invalid coupon code.',
            ], 422);
        } else {
            $currentDateObject = Carbon::now();

            // if valid to is a previous than current date
            if ($coupon->valid_to < $currentDateObject) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Coupon expired.',
                ], 422);
            }

            // if valid from is future date than current date
            if ($coupon->valid_from > $currentDateObject) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Invalid coupon code.',
                ], 422);
            }


            if ($coupon->discount_type === DiscountType::FIXED->value) {
                $discountPriceObject = MoneyService::parseMoney($coupon->discount_value, $coupon->base_currency);
                $msg = 'Fixed discount £' . $coupon->discount_value;
            } else {
                $value = $coupon->discount_value / 100;
                $discountPriceObject = $price->multiply((string) $value);
                $msg = 'Discount of ' . $coupon->discount_value . '%';
            }
        }

        return [$discountPriceObject, $msg];
    }

}
