<?php

namespace App\Http\Controllers\Backend\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateAdminProfile;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $admin = Auth::guard('admin')->user()->load(['currentTeam', 'roles']);

        return view('backend.profile.index')
            ->with([
                'admin' => $admin
            ]);
    }

    public function update(UpdateAdminProfile $request)
    {
        $admin = Admin::query()->where('id', Auth::guard('admin')->id())->first();
        $admin->update($request->all());

        return to_route('admin.update')
            ->with('success', 'Admin profile updated successfully!');
    }
}
