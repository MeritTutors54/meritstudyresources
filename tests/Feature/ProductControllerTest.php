<?php

use App\Models\Product;
use App\Models\User;

it('product page are always open', function () {
    // Act: Guest attempts to visit the products index
    $response = $this->get(route('products'));

    // Assert: Check for redirect to log in
    $response->assertOk()
        ->assertViewIs('frontend.product.index') // Correct Blade file
        ->assertViewHas('products'); // Passed variable to Blade
});

//it('allows authenticated users to see the product catalog', function () {
//    // Arrange: Create a user and some products using factories
//    $user = User::factory()->create();
//    $product = Product::factory()->create(['name' => 'Wireless Mouse']);
//
//    // Act: Make request as the logged-in user
//    $response = $this->actingAs($user)->get(route('products'));
//
//    // Assert
//    $response->assertOk() // 200 Status
//    ->assertViewIs('frontend.product.index') // Correct Blade file
//    ->assertViewHas('products') // Passed variable to Blade
//    ->assertSee('Wireless Mouse'); // Text present in rendered HTML
//});
