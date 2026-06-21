<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Services\PermissionService;
use App\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::query()->count() > 0) {
            return;
        }

        $admin = Admin::query()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'team_id' => 1
        ]);

        PermissionService::shift(1, $admin, 'super-admin');
    }
}
