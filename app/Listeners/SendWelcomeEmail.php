<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\NewUserMail;
use App\Mail\UserRegister;
use App\Models\UserToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\PermissionRegistrar;

class SendWelcomeEmail implements ShouldQueue
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $request =  $event->request ?? null;
        $type = $event->type ?? null;



        if (!empty($type) && $type == 'school-teacher') {
            $team = $user->getCurrentTeam;
            app(PermissionRegistrar::class)->setPermissionsTeamId($team->id);
            if ($user->hasRole('teacher')) {
                Mail::to($user->email)->send(new NewUserMail($request));
            }
        } else {
            $token =  UserToken::query()->where('email', $user->email)->first();
            $app_url = config('app.url');

            Mail::to($user->email)->send(new UserRegister($token->token, $app_url));
        }
    }
}
