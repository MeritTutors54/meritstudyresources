<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        if (Role::query()->exists()) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->basicRoles() as $guard => $roles) {
            foreach ($roles as $roleName) {
                Role::firstOrCreate([
                    'name' => $roleName,
                    'team_id' => $guard === 'web' ? 2 : 1,
                    'guard_name' => $guard,
                ]);
            }
        }
    }

    public function basicRoles(): array
    {
        return [
            'web' => [
                'admin',
                'teacher',
            ],
            'admin' => [
                'super-admin',
                'admin',
                'editor'
            ]
        ];
    }
}
