<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $exists = Permission::query()
            ->where('guard_name', 'admin')
            ->get()->pluck('name')->toArray();

        $adminPermissions = config('permission-list')['admin-section'];

        //for admin permission only
        foreach ($adminPermissions as $subPermissions) {
            foreach ($subPermissions as $permission) {
                if (!in_array($permission, $exists)) {
                    Permission::query()->create([
                        'name' => $permission,
                        'guard_name' => 'admin',
                    ]);
                }
            }
        }

        ############################################################################

        $existWeb = Permission::query()
            ->where('guard_name', 'web')
            ->get()->pluck('name')->toArray();

        $schoolPermissions = config('permission-list')['school-section'];

        // for web guard only
        foreach ($schoolPermissions as $subs) {
            foreach ($subs as $perm) {
                if (!in_array($perm, $existWeb)) {
                    Permission::query()->create([
                        'name' => $perm,
                        'guard_name' => 'web',
                    ]);
                }
            }
        }
    }
}
