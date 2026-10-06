<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
 * Bookshop page — built on these tables:
 *
 *   book_categories : id, name (Year 1 … A Level), slug, status
 *   book_subjects   : id, book_category_id, name, slug, status
 *   products        : id, title, year_group_id (→ book_categories.id),
 *                     subjects (→ book_subjects.id), sku, description,
 *                     amazon_link, status, prices,
 *                     product_soluition → COVER THUMBNAIL (products/solutions/xxx.jpg)
 *                     product_image     → PDF downloads   (products/samples/xxx.pdf, JSON list)
 *                     solution_types    → names for those downloads (JSON ids → product_solutions.id)
 *   product_solutions : id, solution_name (1 = Answer Book, 2 = Test Answer)
 *
 * Cover image, first one found:
 *   1. products.product_soluition   2. products.image
 *   3. public/frontend/new/images/books/book-cover-placeholder.svg
 *
 * Files are read from the public disk: storage/app/public/products/...
 * served as /storage/products/... (needs `php artisan storage:link`).
 *
 * URL examples:
 *   /book-shop                          → first year that has books
 *   /book-shop?year=year-2              → Year 2, its first subject
 *   /book-shop?year=year-2&subject=mathematics
 *   /book-shop?code=23645               → finds the book by SKU (for QR codes)
 */
class BookShopController extends Controller
{
    /** Cover colours used when a book has no image yet (same order as the design). */
    private const COVER_COLOURS = ['green', 'blue', 'orange', 'purple'];

    /** product_solutions id → name, loaded once per request. */
    private array $solutionNames = [];

    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'];
    private const PLACEHOLDER      = 'frontend/new/images/books/book-cover-placeholder.svg';

    public function index(Request $request)
    {
        // ----- QR code: /book-shop?code=SKU → jump to that book's year + subject
        if ($code = trim((string) $request->query('code'))) {
            $book = Product::where('status', 1)->where('sku', $code)->first();

            if ($book) {
                $category = BookCategory::find($book->year_group_id);
                $subject  = BookSubject::find($book->subjects);

                return redirect()->to(url()->current() . '?' . http_build_query(array_filter([
                    'year'    => $category?->slug,
                    'subject' => $subject?->slug,
                    'book'    => $book->id,
                ])) . '#books');
            }

            session()->flash('lookup_error', "We couldn't find a book with the code \"{$code}\".");
        }

        // ----- Year pills (book_categories)
        $categories = BookCategory::where('status', 1)->orderBy('id')->get();

        // which years have at least one active book
        $yearsWithBooks = Product::where('status', 1)->distinct()->pluck('year_group_id')->all();

        $category = $request->filled('year')
            ? $categories->firstWhere('slug', $request->query('year'))
            : ($categories->first(fn ($c) => in_array($c->id, $yearsWithBooks)) ?? $categories->first());

        abort_if($request->filled('year') && ! $category, 404);

        // ----- Subject pills (book_subjects for this year)
        $subjects = $category
            ? BookSubject::where('status', 1)->where('book_category_id', $category->id)->orderBy('id')->get()
            : collect();

        $subject = $request->filled('subject')
            ? $subjects->firstWhere('slug', $request->query('subject'))
            : $subjects->first();

        // ----- Books for this year + subject
        $products = Product::where('status', 1)
            ->when($category, fn ($q) => $q->where('year_group_id', $category->id))
            ->when($subject, fn ($q) => $q->where('subjects', $subject->id))
            ->orderBy('id')                          // book 1, 2, 3, 4 in the order they were added
            ->get();

        $this->solutionNames = DB::table('product_solutions')->pluck('solution_name', 'id')->all();

        $books = $products->values()->map(fn ($p, $i) => $this->bookForView($p, $i, $category, $subject));

        return view('frontend.product.index-2', [
            'categories' => $categories,
            'category'   => $category,
            'subjects'   => $subjects,
            'subject'    => $subject,
            'books'      => $books,
        ]);
    }

    /** Everything one book card needs, worked out here so the Blade stays simple. */
    private function bookForView(Product $p, int $index, ?BookCategory $category, ?BookSubject $subject): array
    {
        // ----- Names: solution_types → product_solutions  (e.g. ["Answer Book", "Test Answer"])
        $solutionNames = collect($this->pathList($p->solution_types))
            ->map(fn ($id) => $this->solutionNames[(int) $id] ?? null)
            ->filter()
            ->values()
            ->all();

        // ----- Downloads: PDFs in product_image (products/samples/...), named from solution_types
        $files = array_values(array_filter(
            $this->pathList($p->product_image),
            fn ($f) => ! $this->isImage($f)
        ));

        $downloads = [];
        foreach ($files as $i => $path) {
            if (count($files) === 1) {
                $label = implode(' & ', $solutionNames) ?: 'Download';      // one file → all names
            } else {
                $label = $solutionNames[$i] ?? 'Download ' . ($i + 1);       // file 1 → name 1, file 2 → name 2
            }

            $downloads[] = ['label' => $label, 'url' => $this->fileUrl($path)];
        }

        $amazon = trim((string) $p->amazon_link);

        return [
            'id'          => $p->id,
            'number'      => $index + 1,
            'title'       => $p->title,
            'series'      => trim(($category?->name ?? '') . ' ' . ($subject?->name ?? '')),
            'description' => Str::limit(strip_tags((string) $p->description), 140),
            'cover'       => $this->coverUrl($p),
            'colour'      => self::COVER_COLOURS[$index % count(self::COVER_COLOURS)],
            'amazon'      => filter_var($amazon, FILTER_VALIDATE_URL) ? $amazon : null,
            'downloads'   => $downloads,
            'includes'    => $solutionNames,                 // chips: Answer Book, Test Answer
            'price'       => $p->discount_price ?: $p->regular_price,
        ];
    }

    /** Cover thumbnail — never null, so every card shows a picture. */
    private function coverUrl(Product $p): string
    {
        $path = collect([
            $this->pathList($p->product_soluition)[0] ?? null,   // 1. thumbnail (products/solutions/xxx.jpg)
            $p->image,                                         // 2. products.image
        ])->first(fn ($v) => is_string($v) && trim($v) !== '' && $this->isImage($v));

        return $path ? $this->fileUrl($path) : asset(self::PLACEHOLDER);   // 3. placeholder
    }

    private function isImage(string $path): bool
    {
        return in_array(strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?? $path, PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS);
    }

    /** Accepts an array, a JSON array, a double-encoded JSON array, a plain path or a plain id. */
    private function pathList($value): array
    {
        for ($i = 0; $i < 3 && is_string($value); $i++) {
            $decoded = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                break;
            }
            $value = $decoded;
        }

        if (is_scalar($value) && $value !== '' && $value !== null) {
            return [(string) $value];      // a single plain path or id
        }

        return array_values(array_map('strval', array_filter(
            (array) $value,
            fn ($v) => (is_string($v) || is_numeric($v)) && $v !== ''
        )));
    }

    /** Files are saved like "products/samples/xyz.pdf" on the public disk. */
    private function fileUrl(string $path): string
    {
        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : asset('storage/' . ltrim($path, '/'));
    }
}