<?php

namespace Tests\Feature;

use App\Enums\UserType;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\SiteSettingsSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function test_unauthenticated_user_cannot_add_product_to_cart()
    {
        $product = Product::query()->inRandomOrder()->first();

        if (empty($product))
        {
            return;
        }

        $payload = [
            'product_id' => $product->id
        ];

        $response = $this->post(route('ajax.add.cart'), $payload);
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_add_product_to_cart()
    {


        $this->seed([
           SiteSettingsSeeder::class
        ]);

        $team = Team::query()->where('name', 'General-Team')
            ->where('guard_name', 'web')->first();

        $user = User::query()->updateOrCreate(
            [
                'email' => 'testing@example.com', // Search criteria
            ],
            [
                'name' => 'Test User',
                'parent_id' => null,
                'team_id' => $team->id,
                'password' => Hash::make('password'),
                'type' => UserType::STUDENT->value,
            ]
        );

        $user->email_verified_at = now();
        $user->save();

        $product = Product::query()->inRandomOrder()->first();

        if (empty($product))
        {
            return;
        }

        $payload = [
            'product_id' => $product->id
        ];

        $response = $this->actingAs($user, 'web')
            ->post(route('ajax.add.cart'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Added to cart successfully.',
                'count' => 1,
            ]);
    }
}

//
//it('allows all users to visit products/all-products page', function () {
//    // Act: Guest attempts to visit the products index
//    $response = $this->get(route('products'));
//
//    // Assert: Check for redirect to log in
//    $response->assertOk()
//        ->assertViewIs('frontend.product.index-2')
//        ->assertViewHas('products')
//        ->assertViewHas('defaultSEO');
//});




//it('allows all user to show each product details', function () {
//    $product = Product::factory()->create([
//        'slug'   => 'sample-product-slug',
//        'status' => Status::ACTIVE->value, // Adjust based on your schema/enums
//    ]);
//
//    $response = $this->get(route('single.product', ['product_slug' => $product->slug]));
//
//    $response->assertOk()
//        ->assertViewIs('frontend.product.details-2') // Replace with your actual Blade view name
//        ->assertViewHas('product', function ($viewProduct) use ($product) {
//            return $viewProduct->id === $product->id;
//        })
//        ->assertSee($product->name);
//});
