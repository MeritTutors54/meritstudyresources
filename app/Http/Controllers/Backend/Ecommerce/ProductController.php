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

    // public function edit(Product $product): View
    // {
    //     $this->authorize('updateProduct', $product);

    //         // Year Groups
    //         $yearGroups = DB::table('year_groups')
    //             ->orderBy('id', 'asc')
    //             ->get();

    //         // Product Solutions
    //         $solution = DB::table('product_solutions')
    //             ->orderBy('id', 'asc')
    //             ->get();

    //         // Statuses
   
    //          $statuses = Status::cases();

    //         return view(
    //             'backend.ecommerce.product.edit',
    //             compact(
    //                 'product',
    //                 'yearGroups',
    //                 'solution',
    //                 'statuses'
    //             )
    //         );
          
    // }


 private function jsonToArray($value): array
{
    if (is_array($value)) {
        return $value;
    }
 
    if (empty($value)) {
        return [];
    }
 
    $decoded = json_decode($value, true);
 
    return is_array($decoded) ? $decoded : [];
}
 
 
/*
|--------------------------------------------------------------------------
| EDIT
|--------------------------------------------------------------------------
*/
public function edit(Product $product): View
{
    $this->authorize('updateProduct', $product);
 
    // Year Groups
    $yearGroups = DB::table('year_groups')
        ->orderBy('id', 'asc')
        ->get();
 
    // Product Solutions
    $solution = DB::table('product_solutions')
        ->orderBy('id', 'asc')
        ->get();
 
    // Statuses
    $statuses = Status::cases();
 
    /*
    |--------------------------------------------------------------------------
    | Existing PDF samples
    |--------------------------------------------------------------------------
    | product_image  -> JSON array of sample file paths
    | solution_types -> JSON array of solution IDs (same order)
    */
    $samplePaths   = $this->jsonToArray($product->product_image);
    $sampleTypes   = $this->jsonToArray($product->solution_types);
    $solutionNames = $solution->pluck('solution_name', 'id');
 
    $samples = collect($samplePaths)->map(function ($path, $index) use ($sampleTypes, $solutionNames) {
        $typeId = $sampleTypes[$index] ?? null;
 
        return (object) [
            'index'         => $index,
            'path'          => $path,
            'url'           => asset('storage/' . $path),
            'solution_id'   => $typeId,
            'solution_name' => $typeId ? ($solutionNames[$typeId] ?? 'Unknown type') : 'No type',
        ];
    });
 
    return view(
        'backend.ecommerce.product.edit',
        compact(
            'product',
            'yearGroups',
            'solution',
            'statuses',
            'samples'
        )
    );
}
 
 
/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/
public function update(Request $request, Product $product): RedirectResponse
{
    $this->authorize('updateProduct', $product);
 
    $validated = $request->validate([
        'title' => 'required|string|max:255',
 
        // ignore the current product when checking unique SKU
        'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
 
        'year_group_id' => 'nullable|integer',
 
        'subjects' => 'nullable|integer',
 
        'regular_price' => 'required|numeric|min:0',
 
        'discount_price' => 'nullable|numeric|min:0',
 
        'description' => 'nullable|string',
 
        'amazon_link' => 'nullable|string|max:2000',
 
        'status' => 'required|boolean',
 
        // Main product file (optional on edit: keep old one if empty)
        'file' => 'nullable|file|max:20480',
 
        // New samples
        'solution_type' => 'nullable|array',
        'pdf_sample' => 'nullable|array',
        'pdf_sample.*' => 'nullable|file|mimes:pdf|max:20480',
 
        // Indexes of existing samples to delete
        'deleted_samples' => 'nullable|array',
        'deleted_samples.*' => 'integer',
    ]);
 
    DB::beginTransaction();
 
    // files to remove from disk only after the DB commit succeeds
    $filesToDelete = [];
    // newly uploaded files to clean up if something fails
    $newFiles = [];
 
    try {
 
        /*
        |--------------------------------------------------------------------------
        | Slug (regenerate only when the title changed)
        |--------------------------------------------------------------------------
        */
        $slug = $product->slug;
 
        if ($validated['title'] !== $product->title || empty($slug)) {
 
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;
 
            while (
                Product::where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
            ) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
 
 
        /*
        |--------------------------------------------------------------------------
        | Main Product File (product_soluition)
        |--------------------------------------------------------------------------
        */
        $productSolution = $product->product_soluition;
 
        if ($request->hasFile('file')) {
 
            $productSolution = $request
                ->file('file')
                ->store('products/solutions', 'public');
 
            $newFiles[] = $productSolution;
 
            if ($product->product_soluition) {
                $filesToDelete[] = $product->product_soluition;
            }
        }
 
 
        /*
        |--------------------------------------------------------------------------
        | Existing samples: remove the deleted ones
        |--------------------------------------------------------------------------
        */
        $oldPaths = $this->jsonToArray($product->product_image);
        $oldTypes = $this->jsonToArray($product->solution_types);
 
        $deleteIndexes = array_map('intval', $validated['deleted_samples'] ?? []);
 
        $productImages = [];
        $solutionTypes = [];
 
        foreach ($oldPaths as $index => $path) {
 
            if (in_array($index, $deleteIndexes, true)) {
                $filesToDelete[] = $path;
                continue;
            }
 
            $productImages[] = $path;
            $solutionTypes[] = $oldTypes[$index] ?? null;
        }
 
 
        /*
        |--------------------------------------------------------------------------
        | New samples (type + file kept in the same position)
        |--------------------------------------------------------------------------
        */
        $newTypes = $request->input('solution_type', []);
 
        foreach ($request->file('pdf_sample', []) as $i => $pdf) {
 
            if (!$pdf) {
                continue;
            }
 
            $path = $pdf->store('products/samples', 'public');
 
            $newFiles[] = $path;
            $productImages[] = $path;
            $solutionTypes[] = !empty($newTypes[$i]) ? (int) $newTypes[$i] : null;
        }
 
 
        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */
        $product->update([
 
            'title' => $validated['title'],
 
            'year_group_id' => $validated['year_group_id'] ?? null,
 
            'slug' => $slug,
 
            'sku' => $validated['sku'],
 
            'description' => $validated['description'] ?? null,
 
            'regular_price' => $validated['regular_price'],
 
            'discount_price' => $validated['discount_price'] ?? null,
 
            'status' => $validated['status'],
 
            'amazon_link' => $validated['amazon_link'] ?? null,
 
            'subjects' => $validated['subjects'] ?? null,
 
            'solution_types' => !empty($solutionTypes)
                ? json_encode($solutionTypes)
                : null,
 
            'product_image' => !empty($productImages)
                ? json_encode($productImages)
                : null,
 
            'product_soluition' => $productSolution,
        ]);
 
 
        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */
        AdminActivity::track([
            'action' => 'updated',
            'model_type' => Product::class,
        ], $product);
 
 
        DB::commit();
 
        // Delete old files only after everything saved successfully
        if (!empty($filesToDelete)) {
            Storage::disk('public')->delete($filesToDelete);
        }
 
        return to_route('admin.products.edit', $product)
            ->with(
                'success',
                'Product has been updated successfully.'
            );
 
    } catch (\Throwable $e) {
 
        DB::rollBack();
 
        // Remove any files uploaded during this failed request
        if (!empty($newFiles)) {
            Storage::disk('public')->delete($newFiles);
        }
 
        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );
    }
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
