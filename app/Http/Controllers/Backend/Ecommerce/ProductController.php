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
use Str;

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
public function store(Request $request)
{
    $this->authorize('createProduct', Auth::user());

    $validated = $request->validate([
        'title' => 'required|string|max:255',

        'sku' => 'required|string|max:255|unique:products,sku',

        'year_group_id' => 'nullable|integer',

        'subjects' => 'nullable|integer',

        'regular_price' => 'required|numeric|min:0',

        'discount_price' => 'nullable|numeric|min:0',

        'description' => 'nullable|string',

        'amazon_link' => 'nullable|string|max:2000',

        'status' => 'required|boolean',

        /*
        |--------------------------------------------------------------------------
        | Solution Types
        |--------------------------------------------------------------------------
        */
        'solution_type' => 'nullable|array',

        /*
        |--------------------------------------------------------------------------
        | Main Product Solution File
        |--------------------------------------------------------------------------
        */
        'file' => 'nullable|file|max:20480',

        /*
        |--------------------------------------------------------------------------
        | PDF Samples
        |--------------------------------------------------------------------------
        */
        'pdf_sample' => 'nullable|array',

        'pdf_sample.*' => 'nullable|file|mimes:pdf|max:20480',
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($validated['title']);

        /*
        |--------------------------------------------------------------------------
        | Make sure slug is unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::where('slug', $slug)->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Main Product Solution
        |--------------------------------------------------------------------------
        */

        $productSolution = null;

        if ($request->hasFile('file')) {

            $productSolution = $request
                ->file('file')
                ->store('products/solutions', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | PDF Samples
        |--------------------------------------------------------------------------
        */

        $productImages = [];

        if ($request->hasFile('pdf_sample')) {

            foreach ($request->file('pdf_sample') as $pdf) {

                if ($pdf) {

                    $path = $pdf->store(
                        'products/samples',
                        'public'
                    );

                    $productImages[] = $path;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Solution Types
        |--------------------------------------------------------------------------
        */

        $solutionTypes = $validated['solution_type'] ?? [];


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create([

            'book_variant_id' => null,

            'title' => $validated['title'],

            'year_group_id' => $validated['year_group_id'] ?? null,

            'slug' => $slug,

            'sku' => $validated['sku'],

            'description' => $validated['description'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | Product Image
            |--------------------------------------------------------------------------
            |
            | If your "image" field is for a cover image, leave it null
            | because your current form does not have a cover-image field.
            |
            */
            'image' => null,

            'regular_price' => $validated['regular_price'],

            'discount_price' => $validated['discount_price'] ?? null,

            'discount_percentage' => null,

            'base_currency' => 'GBP',

            'search_text' => null,

            'status' => $validated['status'],

            'amazon_link' => $validated['amazon_link'] ?? null,

            'subjects' => $validated['subjects'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | Store solution type IDs as JSON
            |--------------------------------------------------------------------------
            */
            'solution_types' => !empty($solutionTypes)
                ? json_encode($solutionTypes)
                : null,

            /*
            |--------------------------------------------------------------------------
            | Store PDF sample paths as JSON
            |--------------------------------------------------------------------------
            */
            'product_image' => !empty($productImages)
                ? json_encode($productImages)
                : null,

            /*
            |--------------------------------------------------------------------------
            | Store main product file
            |--------------------------------------------------------------------------
            */
            'product_soluition' => $productSolution,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        AdminActivity::track([
            'action' => 'created',
            'model_type' => Product::class,
        ], $product);


        DB::commit();

        return to_route('admin.products.index')
            ->with(
                'success',
                'Product has been created successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );
    }
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
            $data = $product->update([
                'title' => $request->title ?? $product->title,
                'slug' => $request->slug ?? $product->slug,
                'book_variant_id' => $request->book_variant_id ?? $product->book_variant_id,
                'description' => $request->description ?? $product->description,
                'regular_price' => $request->regular_price ?? $product->mirror_price,
                'discount_price' => $request->discount_price ?? $product->mirror_discount,
                'discount_percentage' => $request->discount_percentage ?? $product->discount_percentage,
                'sku' => $request->sku ?? $product->sku,
                'year_group_id' => $request->year_group_id ?? $product->year_group_id,
                'image' => $request->image ?? $product->image,
                'status' => $request->status ?? $product->status,
            ]);
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

    public function getSubjectsByYear(Request $request)
    {
        $request->validate([
            'year_group_id' => 'required|integer'
        ]);

        $subjects = DB::table('book_subjects')
            ->where('book_category_id', $request->year_group_id)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'subjects' => $subjects
        ]);
    }

}
