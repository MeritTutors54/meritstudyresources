<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminStuffController extends Controller
{

    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
        setPermissionsTeamId(\App\Enums\Team::TeamAdmin->value);
    }


    public function index()
    {
        $stuffs = Admin::query()
            ->where('username', '!=', 'admin')
            ->get();

        return view('backend.stuff.index')
            ->with([
                'stuffs' => $stuffs,
            ]);
    }

    public function create()
    {
        $this->authorize('createStuff', Auth::user());

        $statuses = Status::cases();

        $roles = Role::query()->where('guard_name', 'admin')->get();

        return view('backend.stuff.form')
            ->with([
                'statuses' => $statuses,
                'roles' => $roles,
            ]);
    }

    public function store(StoreAdminRequest $request)
    {
        $this->authorize('createStuff', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Admin',
        ];

        DB::beginTransaction();
        try {
            $stuff = Admin::query()->create($request->except('_token', '_method'));

            if (!empty($request->role)) {
                $stuff->assignRole($request->role);
            }

            AdminActivity::track($this->log, $stuff);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Admin stuff created.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.stuffs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function edit(Admin $stuff)
    {
        $this->authorize('editStuff', Auth::user());

        $statuses = Status::cases();

        $roles = Role::query()->where('guard_name', 'admin')->get();

        return view('backend.stuff.form')
            ->with([
                'stuff' => $stuff,
                'statuses' => $statuses,
                'roles' => $roles,
            ]);
    }

    public function update(Request $request, Admin $stuff)
    {
        $this->authorize('editStuff', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Admin',
            'old_data' => json_encode($stuff->toArray()),
        ];

        $request->validate([
            'name' => 'required|string|max:200',
            'username' => 'required|string|max:20|unique:admins,username,' . $stuff->id,
            'email' => 'required|string|email|max:200|unique:admins,email,' . $stuff->id,
            'password' => 'nullable|string|min:6',
            'status' => 'required|in:0,1',
            'role' => 'nullable|exists:roles,name',
        ]);

        $data = $request->all();

        if (is_null($data['password'])) {
            unset($data['password']);
        }

        DB::beginTransaction();

        try {
            $stuff->update($data);

            if (!empty($request->password)) {
                $stuff->update(['password' => Hash::make($request->password)]);
            }

            if (!empty($request->role)) {
                $stuff->syncRoles($request->role);
            }

            AdminActivity::track($this->log, $stuff);
            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Stuff updated.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.stuffs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }


    public function destroy(Admin $stuff)
    {
        $this->authorize('deleteStuff', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Admin',
            'old_data' => json_encode($stuff->toArray()),
        ];

        DB::beginTransaction();
        try {
            // this is mean temporary deleted
            $stuff->update(['status' => -1]);

            AdminActivity::track($this->log, $stuff);
            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Stuff deleted.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.stuffs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function permissions(Admin $stuff)
    {
        $this->authorize('updateStuffPermission', Auth::user());

        $role = $stuff->roles()->first();

        $modelHasPermission = $stuff->permissions()->pluck('name')->toArray();

        $roleHasPermission = $role->permissions->pluck('name')->toArray();

        $permissions = config('permission-list')['admin-section'];

        return view('backend.stuff.permission')
            ->with([
                'stuff' => $stuff,
                'modelHasPermission' => $modelHasPermission,
                'roleHasPermission' => $roleHasPermission,
                'permissions' => $permissions,
            ]);
    }

    public function updatePermissions(Request $request, Admin $stuff)
    {
        $this->authorize('updateStuffPermission', Auth::user());

        $stuff->syncPermissions($request->permissions);

        return to_route('admin.stuff.permissions', [$stuff])
            ->with('success', 'Permissions updated.');
    }
}
