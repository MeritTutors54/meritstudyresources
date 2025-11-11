<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\UserType;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{

    protected array $msg = [];

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(): View | RedirectResponse
    {
        if (UserType::from(Auth::user()->type ?? "")->name !== UserType::SCHOOL->name) {
            return to_route('user.dashboard')
                ->with('error', 'You are not allowed to access this page.');
        }

        $users = User::query()
            ->where('parent_id', Auth::id())
            ->get();

        return view('frontend.dashboard.users.index')
            ->with([
                'users' => $users,
            ]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        if (UserType::from(Auth::user()->type ?? "")->name !== UserType::SCHOOL->name) {
            return to_route('user.dashboard')
                ->with('error', 'You are not allowed to access this page.');
        }

        if (!$user->subscribed('default')) {
            return to_route('users.index')
                ->with('error', 'You are not allowed to access this page. Please subscribe first.');
        }

        if ($user->remaining_users === 0) {
            return to_route('users.index')
                ->with('error', 'You are out of limit to add user.');
        }

        return view('frontend.dashboard.users.form');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        if (UserType::from(Auth::user()->type ?? "")->name !== UserType::SCHOOL->name) {
            return to_route('user.dashboard')
                ->with('error', 'You are not allowed to perform this action.');
        }

        DB::beginTransaction();
        try {
            $user = User::query()->create($request->all());
            app(PermissionRegistrar::class)->setPermissionsTeamId($request->team_id);
            $user->assignRole('teacher');
            $user->markEmailAsVerified();

            UserRegistered::dispatch($user, $request->all(), 'school-teacher');

            $this->msg['message'] = 'User created successfully.';
            $this->msg['type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->msg['message'] = $e->getMessage();
            $this->msg['type'] = 'error';
        }

        return to_route('users.index')
            ->with($this->msg['type'], $this->msg['message']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
            'status' => 200,
        ]);
    }

    public function permission(User $user): View
    {
        $modelHasPermission = $user->permissions()->pluck('name')->toArray();

        $permissions = config('permission-list')['school-section'];

        return view('frontend.dashboard.users.permissions')
            ->with([
                'user' => $user,
                'permissions' => $permissions,
                'modelHasPermission' => $modelHasPermission,
            ]);
    }

    public function updatePermission(Request $request, User $user): RedirectResponse
    {
        $user->syncPermissions($request->permissions);

        return to_route('user.permission', [$user])
            ->with('success', 'Permissions updated successfully.');
    }

}
