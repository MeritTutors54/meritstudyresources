<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            TeamSeeder::class,
            SiteSettingsSeeder::class,

            AdminSeeder::class,

            SubscriptionPlanSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
        ]);

    }
}
