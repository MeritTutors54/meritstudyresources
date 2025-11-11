<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (SiteSettings::query()->count() > 0) {
            return;
        }

        SiteSettings::query()->create([
            'name' => 'Merit Tutors',
        ]);
    }
}
