<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Cart;
use App\Models\PastPaper;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\SubscriptionPlan;
use App\Operations\Backend\CartActivity;
use App\Operations\Frontend\CouponActivity;
use App\Services\MoneyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AjaxController extends Controller
{
    public function getSubjects(Request $request): JsonResponse
    {
        $subjects = Subject::query()
            ->where('education_level_id', $request->education_level_id)
            ->where('status', Status::ACTIVE->value)
            ->get();

        return response()->json($subjects);
    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $loginController = new LoginController();

        $loginController->login($request);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
        ], 200);
    }

    public function checkAllPacks(Request $request): JsonResponse
    {
        $user = auth()->user();

        $q = $request->query('q');

        if (!$user) {
            return response()->json([
                'type' => 'error',
                'action' => 'redirect',
                'message' => 'Please login to continue.',
                'redirect' => route('login')
            ]);
        }

        $requestedPlan = SubscriptionPlan::query()
            ->where('slug', $q)
            ->where('status', Status::ACTIVE->value)
            ->first();

        //check if the user type and subscription type is same
        if (UserType::from($user->type ?? '')->name !== SubscriptionType::from($requestedPlan->type)->name) {
            return response()->json([
                'type' => 'error',
                'message' => 'You are not allowed to checkout this package.'
            ]);
        }

        $activePlan = $user->active_subscription_plan ?? '';

        if (!empty($activePlan)) {
            if ($activePlan->duration === $requestedPlan->duration) {
                if ($activePlan->id === $requestedPlan->id) {
                    return response()->json([
                        'type' => 'error',
                        'message' => "You are already subscribed to this package."
                    ]);
                }

                // usually user cannot downgrade their package to lower
                // if they can only upgrade
                if ($activePlan->level > $requestedPlan->level) {
                    return response()->json([
                        'type' => 'error',
                        'message' => "You can't downgrade your package."
                    ]);
                }
            }

            return response()->json([
                'type' => 'error',
                'message' => "Please cancel the current subscription first."
            ]);
        }


        return response()->json([
            'type' => 'success',
            'message' => ""
        ]);
    }

    public function addToCart(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The selected product ID does not exist in our records.',
        ]);

        $userID = Auth::id();
        $productID = $request->product_id;

        $checkCart = Cart::query()
            ->where('user_id', $userID)
            ->where('product_id', $productID)
            ->first();

        if ($checkCart) {
            $checkCart->quantity += 1;
            $checkCart->save();
        } else {
            $request->merge([
                'user_id' => Auth::id(),
                'quantity' => 1,
            ]);

            $cart = Cart::query()->create($request->all());
        }

        $allCartCount = Cart::query()
            ->where('user_id', $userID)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully.',
            'count' => $allCartCount
        ], 200);
    }

    public function cartItem(Request $request): JsonResponse
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'type' => 'required',
        ]);

        $cart = Cart::query()
            ->where('user_id', Auth::id())
            ->where('id', $request->cart_id)
            ->first();

        // type 1 = minus call, type 2 = plus call, type 3 = delete
        if ($request->type == 3) {
            $cart->delete();
        } else {
            if ($cart->quanitity != 1) {
                // type 1 = minus call
                if ($request->type == 1) {
                    $cart->update([
                        'quantity' => $cart->quantity - 1,
                    ]);
                }
                // type 2 = plus call
                if ($request->type == 2) {
                    $cart->update([
                        'quantity' => $cart->quantity + 1,
                    ]);
                }
            }
        }

        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->get();

        [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject] = CartActivity::getAllDependantValues($cartItems);

        $subTotalPrice = MoneyService::convertToReadableMoney($subTotalPriceObject);
        $grandTotalPrice = MoneyService::convertToReadableMoney($grandTotalPriceObject);
        $deliveryCharge = MoneyService::convertToReadableMoney($deliveryChargeObject);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'unitPrice' => $cart->total,
            'subTotalPrice' => $subTotalPrice,
            'grandTotalPrice' => $grandTotalPrice,
            'deliveryCharge' => $deliveryCharge,
            'count' => $cartItems->count(),
        ], 200);
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $cartItems = Cart::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->get();

        [$subTotalPriceObject, $grandTotalPriceObject, $deliveryChargeObject] = CartActivity::getAllDependantValues($cartItems);


        $couponResult = CouponActivity::applyingCoupon($request->coupon_code, $grandTotalPriceObject);

        if (!is_array($couponResult) && $couponResult->status() == 422) {
            return $couponResult;
        }

        $grandTotalPrice = MoneyService::convertToReadableMoney($grandTotalPriceObject);



        $grandTotalPriceObject = $grandTotalPriceObject->subtract($couponResult[0]);
        $discountPrice = MoneyService::convertToReadableMoney($couponResult[0]);
        $currentGrandTotalPrice = MoneyService::convertToReadableMoney($grandTotalPriceObject);

        return response()->json([
            'success' => true,
            'message' => $couponResult[1],
            'grandTotalPrice' => $grandTotalPrice,
            'currentGrandTotalPrice' => $currentGrandTotalPrice,
            'discountPrice' => $discountPrice,
        ]);
    }

    public function getSubCategory($category_id): JsonResponse
    {
        $data = SubCategory::query()
            ->where('category_id', $category_id)
            ->where('is_deleted', 0)
            ->where('is_active', 1)
            ->select(['subcategory_name', 'id'])->get();

        return response()->json($data);
    }

    public function getReSubCategory($subcategory_id): JsonResponse
    {
        $data = Resubcategory::query()
            ->where('subcategory_id', $subcategory_id)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        return response()->json($data);
    }

    public function getPastPaper(Request $request): JsonResponse
    {
        $searchValue = $request->optionalSearch;

        // $pastPapers = PastPaper::query()
        //     ->with(['series'])
        //     ->where('title', $request->title)
        //     ->where('category', $request->category_id)
        //     ->where('subcategory', $request->subcategory_id)
        //     ->where('resubcategory', $request->resubcategory_id)
        //     ->whereHas('series', function ($query) use ($searchValue) {
        //         $query->when($searchValue, function ($q) use ($searchValue) {
        //             $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchValue}%"]);
        //         });
        //     })
        //     ->get()
        //     ->sortByDesc(function ($paper) {
        //         return strtotime($paper->series->name);
        //     })
        //     ->groupBy(function ($paper) {
        //         return $paper->series->name;
        //     });


        $buildPastPapersQuery = function (?string $search = null) use ($request) {
            return PastPaper::query()
                ->with('series')
                ->where('title', $request->title)
                ->where('category', $request->category_id)
                ->where('subcategory', $request->subcategory_id)
                ->where('resubcategory', $request->resubcategory_id)
                ->when(filled($search), function ($query) use ($search) {
                    $query->whereHas('series', function ($seriesQuery) use ($search) {
                        $seriesQuery->whereRaw(
                            'LOWER(name) LIKE ?',
                            ['%' . mb_strtolower($search) . '%']
                        );
                    });
                });
        };

        $pastPapers = $buildPastPapersQuery($searchValue)->get();

        // If searchValue was provided but no records matched, return all records
        if (filled($searchValue) && $pastPapers->isEmpty()) {
            $pastPapers = $buildPastPapersQuery(null)->get();
        }

        $pastPapers = $pastPapers
            ->sortByDesc(function ($paper) {
                return strtotime($paper->series->name);
            })
            ->groupBy(function ($paper) {
                return $paper->series->name;
            });


        return response()->json($pastPapers);
    }
}
