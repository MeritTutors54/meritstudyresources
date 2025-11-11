<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (SubCategory::query()->count() > 0) {
            return;
        }

        $subName = [
            'Mathematics',
            'English Language',
            'English Literature',
            'Physics',
            'Biology',
            'Science Double Award',
            'Chemistry',
            'English Language A',
            'Information and Communication  Technology',
            'Computer Science',
            'Science (Single Award)',
            'Economics',
            'Science (Double Award)',
            'Business',
            'Psychology',
            'Geography A',
            'Geography B',
            'Geography',
            'Economics A',
            'Economics B',
            'Politics',
            'Sociology',
            'German',
            'French',
            'Spanish',
        ];

        $categories = Category::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                foreach ($subName as $sub) {
                    SubCategory::query()->create([
                        'name' => $sub,
                        'slug' => SlugService::generateSlug($sub),
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
