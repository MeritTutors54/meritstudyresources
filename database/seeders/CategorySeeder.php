<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::query()->count() > 0) {
            return;
        }

        $categories = [
            'A Level',
            'AS Level',
            'GCSE',
            'IGCSE',
            'Law'
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'name' => $category,
                'slug' => SlugService::generateSlug($category)
            ]);
        }
    }
}
