<?php

namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Seo::query()->count() > 0) {
            return;
        }

        Seo::query()->create([
            'meta_author' => 'Merit Hub'
        ]);
    }
}
