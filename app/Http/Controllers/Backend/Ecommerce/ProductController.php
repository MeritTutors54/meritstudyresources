<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreProductRequest;
use App\Http\Requests\Backend\UpdateProductRequest;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Models\BookVariant;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\YearGroup;
use App\Operations\Backend\AdminActivity;
use App\Operations\Backend\StripeProductActivity;
use App\Services\FileService;
use App\Services\MoneyService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Money\Currency;
use Money\Money;
use function Symfony\Component\String\s;

class ProductController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewProduct', Auth::user());

        $products = Product::all();

        return view('backend.ecommerce.product.index')
            ->with([
                'products' => $products,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createProduct', Auth::user());

        $statuses = Status::cases();
        $bookVariants = BookVariant::query()
            ->where('status', Status::ACTIVE)
            ->get();
        $yearGroups = YearGroup::query()->get();

        return view('backend.ecommerce.product.form')
            ->with([
                'statuses' => $statuses,
                'bookVariants' => $bookVariants,
                'yearGroups' => $yearGroups
            ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('createProduct', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Product',
        ];

        DB::beginTransaction();

        try {
            $product = Product::query()->create($request->except('_token', '_method'));

            if (count($request->samples ?? []) > 0) {
                foreach ($request->samples ?? [] as $sample) {
                    ProductImage::query()->create([
                        'product_id' => $product->id,
                        'path' => $sample ?? '',
                    ]);
                }
            }

            AdminActivity::track($this->log, $product);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Product has been created';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.products.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function edit(Product $product): View
    {
        $this->authorize('updateProduct', $product);

        $statuses = Status::cases();
        $bookVariants = BookVariant::query()
            ->where('status', Status::ACTIVE)
            ->get();
        $yearGroups = YearGroup::query()->get();

        return view('backend.ecommerce.product.form')
            ->with([
                'product' => $product,
                'statuses' => $statuses,
                'yearGroups' => $yearGroups,
                'bookVariants' => $bookVariants,
            ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('updateProduct', $product);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Product',
            'old_data' => json_encode($product->toArray()),
        ];
        
        DB::beginTransaction();

        try {
            $data = $product->update($request->except('_token', '_method'));

            if (count($request->samples ?? []) > 0) {
                foreach ($request->samples ?? [] as $sample) {
                    ProductImage::query()->create([
                        'product_id' => $product->id,
                        'path' => $sample,
                    ]);
                }
            }

            AdminActivity::track($this->log, $product);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Product has been updated!';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.products.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('deleteProduct', $product);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Product',
            'old_data' => json_encode($product->toArray()),
        ];

        DB::beginTransaction();

        try {
            if ($product->getSampleImages()->count() > 0) {
                foreach ($product->getSampleImages as $prevImage) {
                    FileService::checkFile($prevImage->path);
                }
            }

            if (!empty($this->product->image)) {
                FileService::checkFile($product->image);
            }

            $product->delete();
            AdminActivity::track($this->log, $product);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Product has been deleted!';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.products.index')
            ->with($this->notification['status'], $this->notification['message']);

    }


}
