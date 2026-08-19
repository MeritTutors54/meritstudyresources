<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class PermissionService
{
    public static function shift(int $teamID, Model $model, string $roleName): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        app(PermissionRegistrar::class)->setPermissionsTeamId($teamID);

        $guardName = $model->guard_name ?? 'admin';

        $role = Role::query()->firstOrCreate([
            'name' => $roleName,
            'guard_name' => $guardName,
            'team_id' => $teamID,
        ]);

        $model->assignRole($role);
    }
}
