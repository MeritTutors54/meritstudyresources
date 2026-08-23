<?php


use App\Models\Admin;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Models\BookVariant;
use App\Models\Product;
use App\Models\YearGroup;
use Database\Seeders\AdminSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SiteSettingsSeeder;
use Database\Seeders\TeamSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AdminProductControllerTest extends TestCase
{
//    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

//        Artisan::call('migrate:fresh');

        $this->seed([
            RoleSeeder::class,
            TeamSeeder::class,
            AdminSeeder::class,
            SiteSettingsSeeder::class,
        ]);

        $this->admin = Admin::query()->first();
    }

    public function test_allow_admin_to_insert_into_year_group()
    {
        if (YearGroup::query()->exists()) {
            return;
        }

        $years = ['5', '6', '7', '8'];

        foreach ($years as $year) {
            $payload = [
                'year_name' => $year . ' Year',
            ];

            $response = $this->actingAs($this->admin, 'admin')
                ->post(route('admin.year-groups.store'), $payload);

            $response->assertSessionHasNoErrors()
                ->assertRedirect(route('admin.year-groups.index'));

            $this->assertDatabaseHas('year_groups', [
                'year_name' => $year . ' Year'
            ]);
        }
    }

    public function test_allow_admin_to_insert_into_book_category()
    {
        if (BookCategory::query()->exists()) {
            return;
        }

        $categories = [
            [
                'name' => 'A Level',
                'description' => 'Advanced Level curriculum resources, textbooks, and past paper revisions.',
                'status' => 1,
            ],
            [
                'name' => 'AS Level',
                'description' => 'Advanced Subsidiary Level study materials, foundational course books, and guides.',
                'status' => 1,
            ],
            [
                'name' => 'GCSE',
                'description' => 'General Certificate of Secondary Education textbooks, study aids, and workbooks.',
                'status' => 1,
            ],
            [
                'name' => 'IGCSE',
                'description' => 'International General Certificate of Secondary Education curriculum books and revision notes.',
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            $response = $this->actingAs($this->admin, 'admin')
                ->post(route('admin.book-categories.store'), $category);

            $response->assertSessionHasNoErrors()
                ->assertRedirect(route('admin.book-categories.index'));

            $this->assertDatabaseHas('book_categories', [
                'name' => $category['name'],
                'description' => $category['description'],
                'status' => $category['status'],
            ]);
        }

        // Verify total record count matches the inserted dataset
        $this->assertDatabaseCount('book_categories', count($categories));

    }

    public function test_allow_admin_to_insert_into_book_subject()
    {
        if (BookSubject::query()->exists()) {
            return;
        }

        $category = BookCategory::query()->first();

        if (empty($category)) {
            return;
        }

        $subjects = [
            [
                'name' => 'Mathematics',
                'description' => 'Pure mathematics, mechanics, statistics, and algebraic foundations.',
                'status' => 1,
            ],
            [
                'name' => 'Further Mathematics',
                'description' => 'Advanced mathematical methods, complex numbers, matrices, and differential equations.',
                'status' => 1,
            ],
            [
                'name' => 'Physics',
                'description' => 'Classical mechanics, thermodynamics, waves, electricity, and quantum phenomena.',
                'status' => 1,
            ],
            [
                'name' => 'Chemistry',
                'description' => 'Physical, inorganic, and organic chemistry principles, kinetics, and reactions.',
                'status' => 1,
            ],
            [
                'name' => 'Biology',
                'description' => 'Cell biology, physiology, genetics, ecology, and evolutionary biology.',
                'status' => 1,
            ],
        ];

        foreach ($subjects as $subject) {
            $payload = [
                'book_category_id' => $category->id,
                'name' => $subject['name'],
                'description' => $subject['description'],
                'status' => $subject['status'],
            ];

            $response = $this->actingAs($this->admin, 'admin')
                ->post(route('admin.book-subjects.store'), $payload);

            $response->assertSessionHasNoErrors()
                ->assertRedirect(route('admin.book-subjects.index'));

            $this->assertDatabaseHas('book_subjects', [
                'name' => $subject['name'],
                'book_category_id' => $category->id,
                'description' => $subject['description'],
                'status' => $subject['status'],
            ]);
        }
    }

    public function test_allow_admin_to_insert_into_book_variant()
    {
        if (BookVariant::query()->exists()) {
            return;
        }

        $subjects = BookSubject::with('bookCategory')->get();

        if ($subjects->isEmpty()) {
            return;
        }

        $variantTypes = [
            [
                'name' => 'Age 5-8',
                'description' => 'Foundational learning material tailored for early primary students aged 5 to 8.',
                'status' => 1,
            ],
            [
                'name' => 'Age 9-10',
                'description' => 'Intermediate curriculum content designed for upper primary students aged 9 to 10.',
                'status' => 1,
            ],
            [
                'name' => 'Age 11-14',
                'description' => 'Lower secondary syllabus and practice material for students aged 11 to 14.',
                'status' => 1,
            ],
            [
                'name' => 'Age 15-18',
                'description' => 'Upper secondary and board exam preparation material for students aged 15 to 18.',
                'status' => 1,
            ],
            [
                'name' => 'Age 11-20',
                'description' => 'Comprehensive multi-stage reference guide spanning secondary to early college levels.',
                'status' => 1,
            ],
        ];

        foreach ($subjects as $subject) {
            foreach ($variantTypes as $variant) {
                $payload = [
                    'book_category_id' => $subject->book_category_id,
                    'book_subject_id' => $subject->id,
                    'name' => $variant['name'],
                    'description' => $variant['description'],
                    'status' => $variant['status'],
                ];

                $response = $this->actingAs($this->admin, 'admin')
                    ->post(route('admin.book-variants.store'), $payload);

                $response->assertSessionHasNoErrors()
                    ->assertRedirect(route('admin.book-variants.index'));

                $this->assertDatabaseHas('book_variants', [
                    'name' => $variant['name'],
                    'book_category_id' => $subject->book_category_id,
                    'book_subject_id' => $subject->id,
                    'description' => $variant['description'],
                    'status' => $variant['status'],
                ]);
            }
        }

    }

    public function test_allow_only_authenticated_user_to_create_product()
    {
        $this->withoutExceptionHandling();

        Schema::disableForeignKeyConstraints();
        \App\Models\Product::truncate();
        \App\Models\ProductImage::truncate();
        Schema::enableForeignKeyConstraints();

        Storage::disk('public')->deleteDirectory('products');

        $payload = [
            'title' => 'Advanced Mathematics Book',
            'book_variant_id' => 1,
            'year_group_id' => 2,
            'description' => 'Complete guide for higher secondary students.',
            'regular_price' => 100,
            'discount_price' => 70,
            'status' => 1,
            'file' => UploadedFile::fake()->image('product.jpg')->size(2048),
            'pdf_sample' => [
                UploadedFile::fake()->image('sample1.jpg')->size(2048),
                UploadedFile::fake()->image('sample2.png')->size(2048),
            ],
            // Optional non-validated attributes passed to the model:
            'sku' => 'MATH-2026-001',
        ];

//        dd(route('admin.products.store'));

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.products.store'), $payload);

        $response->assertRedirect(route('admin.products.index'))
            ->assertSessionHasNoErrors();


        $this->assertDatabaseHas('products', [
            'title' => 'Advanced Mathematics Book',
            'sku' => 'MATH-2026-001',
            'regular_price' => 10000,
            'status' => 1,
        ]);
    }

    public function test_allow_only_authenticated_user_to_update_product()
    {
        // 1. Seed an existing product
        $product = Product::query()->first();

        if (empty($product)) {
            return;
        }

        // 2. Prepare payload with updated values & new files
        $updatePayload = [
            'title' => 'Updated Advanced Mathematics Book',
            'book_variant_id' => 2,
            'year_group_id' => 3,
            'description' => 'Updated comprehensive guide for students.',
            'regular_price' => '150.00',
            'discount_price' => '120.00',
            'status' => 1,
            'sku' => 'MATH-2026-UPDATED',
            'file' => UploadedFile::fake()->image('updated_product.jpg'),
            'pdf_sample' => [
                UploadedFile::fake()->image('updated_sample1.jpg'),
                UploadedFile::fake()->image('updated_sample2.png'),
            ],
        ];

        // 3. Perform update request
        $response = $this->actingAs($this->admin, 'admin')
            ->put(route('admin.products.update', $product), $updatePayload);

        // 4. Assert response & redirect
        $response->assertRedirect(route('admin.products.index'))
            ->assertSessionHasNoErrors();

        // 5. Assert database records
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Advanced Mathematics Book',
            'sku' => 'MATH-2026-UPDATED',
            'book_variant_id' => 2,
            'year_group_id' => 3,
            'regular_price' => 15000,
            'status' => 1,
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'title' => $product->title,
            'sku' => $product->sku,
        ]);
    }
}
