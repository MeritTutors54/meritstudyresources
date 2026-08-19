<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(5, true);
        $regular_price = fake()->numberBetween(10, 100);
        $hasDiscount = $this->faker->boolean(40);
        $discountedPrice = $hasDiscount ? fake()->numberBetween(5, $regular_price - 20) : null;
        $discountedPercentage = $hasDiscounted ? fake()->numberBetween(0, 5) : null;


        return [
            //
        ];
    }
}
