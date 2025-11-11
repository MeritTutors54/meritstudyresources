<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeamsPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!empty($user)) {
            if ($user->type == UserType::STUDENT->value) {
                if (empty($user->team_id)) {
                    $this->getTeam($user);
                }

                if (count($user->roles) == 0) {
                    $this->getRole($user);
                }
            }

            setPermissionsTeamId($user->team_id ?? "");
        }

        return $next($request);
    }

    public function getTeam(User $user): void
    {
        $team = Team::query()->where('name', 'General-Team')
            ->first();

        $user->team_id = $team->id;
        $user->save();

    }

    public function getRole(User $user): void
    {
        setPermissionsTeamId($user->team_id ?? "");
        $user->assignRole('admin');
    }
}
