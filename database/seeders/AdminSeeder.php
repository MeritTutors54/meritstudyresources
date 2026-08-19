<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Team;
use App\Services\PermissionService;
use App\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        if (Admin::query()->count() > 0) {
            return;
        }

        $team = Team::query()->firstOrCreate(
            ['name' => 'Team-Admin', 'guard_name' => 'admin']
        );

        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

        $admin = Admin::query()->firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'status' => 1,
                'team_id' => $team->id,
            ]
        );

        Log::info($admin);

        $role = Role::query()->firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'admin',
            'team_id' => $team->id
        ]);

//        setPermissionsTeamId($team->id);
        $p = getPermissionsTeamId();
        Log::info('getPermissionsTeamId =' . $p);

        $admin->assignRole($role);
    }
}
