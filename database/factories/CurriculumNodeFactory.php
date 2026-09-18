<?php

namespace Database\Factories;

use App\Models\BoardResource;
use App\Models\Resubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardResource>
 */
class CurriculumNodeFactory extends Factory
{
    protected $model = BoardResource::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence(3);

        return [
            'parent_id' => null,
            'name' => $name,
            'is_group' => false,
        ];
    }
}
