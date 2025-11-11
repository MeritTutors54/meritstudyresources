<?php

namespace App\Http\Controllers;


use App\Enums\UserType;
use App\Events\UserRegistered;
use App\Models\User;
use App\Models\UserDetails;
use App\Operations\Frontend\UserActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Str;

class SocialAuthController extends Controller
{
    protected array $notification;
    public function redirectToGoogle()
    {
        session()->put('url.intended', url()->previous());

        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $systemUser = User::query()->where('email', $googleUser->email)->first();

            if ($systemUser) {
                Auth::loginUsingId($systemUser->id);

                $systemUser->update([
                    'last_login' => now(),
                ]);

                $intendedURL = session()->pull('url.intended');

                if ($intendedURL == route('login')) {
                    return to_route('user.dashboard');
                }

                return redirect($intendedURL);
            } else {
                $userDataArray = [];

                // Add public properties to the array
                $userDataArray['id'] = $googleUser->getId();
                $userDataArray['name'] = $googleUser->getName();
                $userDataArray['email'] = $googleUser->getEmail();
                $userDataArray['avatar'] = $googleUser->getAvatar();
                $userDataArray['token'] = $googleUser->token;

                $encrypted = Crypt::encrypt($userDataArray);

                return view('auth.organize-for-google')
                    ->with([
                        'encrypted' => $encrypted,
                    ]);
            }
        } catch (Exception $e) {
            $this->notification['status'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('login')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function finalCallback(Request $request)
    {
        $data = Crypt::decrypt($request->data);

        try {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'type' => $request->type,
            ]);

            if ($user) {
                UserDetails::query()->create([
                    'user_id' => $user->id,
                    'google_id' => $data['id'],
                ]);
            }

            Auth::loginUsingId($user->id);

            $intendedURL = session()->pull('url.intended');

            if ($intendedURL == route('login')) {
                return to_route('user.dashboard');
            }

            return redirect($intendedURL);
        } catch (\Exception $exception) {
            $this->notification['type'] = 'error';
            $this->notification['text'] = $exception->getMessage();
        }

        return to_route('login')->with($this->notification['status'], $this->notification['message']);
    }
}
