<?php

use App\Enums\Status;
use App\Models\Product;
//use App\Models\User;
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
