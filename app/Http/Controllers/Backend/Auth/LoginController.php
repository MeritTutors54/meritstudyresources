<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('backend.auth.login');
    }


    /**
     * @throws ValidationException
     */
    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::guard('admin')->user();

        if ($user->status == Status::INACTIVE->value) {
            return $this->logout($request)
                ->with('error', 'User is not active.');
        }

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
