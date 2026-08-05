<?php

namespace App\Http\Controllers;

use App\Enums\Activity;
use App\Enums\Status;
use App\Enums\SubscriptionType;
use App\Enums\UserType;
use App\Http\Controllers\Auth\LoginController;
use App\Models\AdminActivityLog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\PastPaper;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\SubscriptionPlan;
use App\Operations\Backend\AdminActivity;
use App\Operations\Backend\CartActivity;
use App\Operations\Frontend\CouponActivity;
use App\Services\MoneyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

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
            ->select(['subcategory_name', 'id'])
            ->orderBy('subcategory_name', 'asc')
            ->get();

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

        $buildPastPapersQuery = function (?string $search = null) use ($request) {
            return PastPaper::query()
                ->with('series')
                ->where('is_active', '=', '1')
                ->when($request->type !== "all", function ($query) use ($request) {
                    $query->where('title', $request->title);
                })
                ->where('category', $request->category_id)
                ->where('subcategory', $request->subcategory_id)
                ->where('resubcategory', $request->resubcategory_id)
                ->whereHas('series', function ($query) {
                    $query->where('is_active', '=', '1');
                })
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

    public function indexData()
    {
        $allData = PastPaper::query()
            ->where('is_deleted', 0)
            ->with('category_model', 'subcategory_model', 'resubcategory_model', 'series')
            ->orderBy('id', 'DESC');

        return DataTables::eloquent($allData)
            ->addIndexColumn()
            ->addColumn('unit_code', function ($row) {
                return $row->resubcategory_model->unit_code ?? '';
            })
            ->addColumn('series_name', function ($row) {
                return $row->series->name ?? '';
            })
            ->addColumn('category_name', function ($row) {
                return $row->category_model->category_name ?? "";
            })
            ->addColumn('subcategory_name', function ($row) {
                return $row->subcategory_model->subcategory_name ?? "";
            })
            ->addColumn('resubcategory_name', function ($row) {
                return $row->resubcategory_model->resubcategory_name ?? "";
            })
            ->addColumn('status_badge', function ($data) {
                $checked = $data->is_active == 1 ? 'checked' : '';

                return view('backend.past-paper._switch_status', compact('data', 'checked'))->render();
            })
            ->addColumn('actions', function ($data) {
                return view('backend.past-paper._action_button', compact('data'))->render();
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);

    }

    public function subcategoryData()
    {
        $allData = SubCategory::query()
            ->with(['category', 'resubcategories'])
            ->where('is_deleted', 0)
            ->orderBy('subcategory_name', 'asc');


        return DataTables::eloquent($allData)
            ->addIndexColumn()
            ->addColumn('subcategory_name', function ($row) {
                return $row->subcategory_name ?? '';
            })
            ->addColumn('most_popular', function ($row) {
                $data = $row;
                return view('backend.past-paper.sub-category._most_popular_switch', compact('data'))->render();
            })
            ->addColumn('category_name', function ($row) {
                return $row->category->category_name ?? "";
            })
            ->addColumn('status', function ($row) {
                $data = $row;
                return view('backend.past-paper.sub-category._status_switch', compact('data'))->render();
            })
            ->addColumn('manage', function ($data) {
                return view('backend.past-paper.sub-category._manage_section', compact('data'))->render();
            })
            ->rawColumns(['most_popular', 'status', 'manage'])
            ->toJson();
    }

    public function updatePastPaper(Request $request)
    {

    }

    public function updateStatus(Request $request)
    {
        $modelName = $request->model;
        $column = $request->column;
        $modelClass = "App\\Models\\" . $modelName;

        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => false,
                'message' => 'Model not found'
            ], 500);
        }

        $object = $modelClass::where('id', $request->category_id)->first();

        if (empty($object)) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }

        if ($object->$column == 1) {
            $object->$column = 0;
            $object->save();
        } else {
            $object->$column = 1;
            $object->save();
        }

        return response()->json([
            'success' => true,
            'message' => $modelName . ' status updated successfully',
        ], 200);
    }

    public function getAllActivityLog(Request $request)
    {
        $q = $request->query('admin_id') ?? null;

        $result = AdminActivityLog::query()
            ->with('admin')
            ->orderBy('id', 'DESC');

        if (!empty($q)) {
            $result->where('admin_id', $q);
        }

        return DataTables::eloquent($result)
            ->addIndexColumn()
            ->addColumn('admin_name', function ($row) {
                return $row->admin->name ?? '';
            })
            ->addColumn('model_name', function ($row) {
                return AdminActivity::splitStudlyCaseToWords($row->model_type);
            })
            ->addColumn('action_badge', function ($row) {
                if ($row->action === strtolower(Activity::CREATED->name)) {
                    return '<span class="btn-sm btn-success">' . Activity::CREATED->name . '</span>';
                } else if ($row->action === strtolower(Activity::DELETED->name)) {
                    return '<span class="btn-sm btn-danger">' . Activity::DELETED->name . '</span>';
                }
                return '<span class="btn-sm btn-warning">' . Activity::UPDATE->name . '</span>';
            })
            ->addColumn('date_time', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s') ?? '';
            })
            ->addColumn('more', function ($row) {
                $route = route('admin.activity.show', [$row]);
                return '<a href="' . $route . '">See More...</a>';
            })
            ->rawColumns(['action_badge', 'more'])
            ->make(true);
    }

}
