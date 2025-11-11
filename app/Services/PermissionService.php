<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

final class PermissionService
{
    public static function shift(int $teamID, Model $model, string $roleName): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($teamID);

        $model->assignRole($roleName);
    }
}
