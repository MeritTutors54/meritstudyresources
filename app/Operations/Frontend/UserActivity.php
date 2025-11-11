<?php

namespace App\Operations\Frontend;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserToken;
use App\Services\SlugService;
use App\Services\TokenService;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Jenssegers\Agent\Agent;
use Spatie\Permission\PermissionRegistrar;

final class UserActivity
{
    public static function lastLogin($user): void
    {
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();
    }

    public static function userTokenGenerate($email): void
    {
        $token = UserToken::query()->where('email', $email)->first();
        if ($token) {
            UserToken::query()->where('email', $email)->delete();
        }

        UserToken::query()->create([
            'email' => $email,
            'token' => TokenService::generateToken(),
        ]);
    }

    public static function creatingTeam(string $name)
    {
        return Team::query()->create([
            'name' => $name . '-' . 'School',
            'guard_name' => 'web',
        ]);
    }

    public static function assignRole(User $user, Team $team): void
    {
        app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);

//        $role = Role::query()
//            ->where('guard_name', 'web')
//            ->where('name', 'admin')
//            ->first();

        $user->assignRole('admin');
    }
}
