<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Operations\Frontend\UserActivity;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Validation\Validator as ValidationResponse;
use Illuminate\View\View;


class RegisterController extends Controller
{
    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('auth.register-2');
    }

    protected function validator(array $request): ValidationResponse
    {
        return Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'same:confirm_password'],
            'agree_term' => ['required', 'accepted'],
        ], [
            'agree_term.required' => "The agreement needs to be accepted.",
        ]);
    }

    public function register(Request $request): View
    {
        $this->validator($request->all())->validate();

        $encrypted = Crypt::encrypt($request->all());

        return view('auth.organize')
            ->with([
                'data' => $encrypted
            ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $team = null;
        $msg = [];

        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('organize')
                ->withErrors($validator)
                ->withInput();
        }

        $data = Crypt::decrypt($request->data);

        DB::beginTransaction();

        try {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $request->type,
            ]);

            if($request->type === (string)UserType::SCHOOL->value) {
                $team = UserActivity::creatingTeam($data['name']);
                UserActivity::assignRole($user, $team);

                $user->team_id = $team->id;
                $user->save();
            }

            UserActivity::userTokenGenerate($user->email);

            event(new UserRegistered($user, $request->all(),'school'));

            $msg['type'] = 'success';
            $msg['text'] = 'Account successfully created. A mail is sent to your email. Please check your inbox.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $msg['type'] = 'error';
            $msg['text'] = $exception->getMessage();
        }

        return to_route('login')
            ->with($msg['type'], $msg['text']);
    }

//    public function organize(): View
//    {
//        return view('auth.organize');
//    }

    public function verification(Request $request): RedirectResponse
    {
        $userToken = UserToken::query()->where("token", $request->token)->first();
        if ($userToken) {
            $user = User::query()->where("email", $userToken->email)->first();
            if ((int)$user->status === 1 && $user->email_verified_at === null) {
                $user->markEmailAsVerified();

                UserToken::query()->where('email', $user->email)->delete();

                return to_route('login')->with('success', 'Email successfully verified. Please login');
            }

            UserToken::query()->where('email', $user->email)->delete();

            return to_route('login')->with('success', 'Already verified. Please login');
        }

        return to_route('login')->with('error', 'Something went wrong while verifying email. Please try again.');
    }
}
