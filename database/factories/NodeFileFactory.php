<?php

namespace Database\Factories;

use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardResourceFile>
 */
class NodeFileFactory extends Factory
{
    protected $model = BoardResourceFile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficulty = $this->faker->randomElement(['Medium', 'Hard']);
        $number = $this->faker->numberBetween(1, 4);

        return [
            'curriculum_node_id' => BoardResource::factory(),
            'title' => "{$difficulty} {$number}",
            'difficulty' => $difficulty,
            'is_pro' => $difficulty === 'Hard',
            'file_path' => 'worksheets/sample.pdf',
        ];
    }
}
