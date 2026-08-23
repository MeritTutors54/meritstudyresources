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
        if (SiteSettings::query()->exists()) {
            return;
        }

        SiteSettings::query()->create([
            'name' => 'Merit Study Resource',
            'delivery_charge' => 5,
        ]);
    }
}
