<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncPermission;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize("viewForAdminRole", Auth::user());

        $roles = Role::query()->where('name', '!=', 'super-admin')->get();
        $permissions = config('permission-list')['admin-section'];

        return view('backend.permission.index')->with([
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function sync(SyncPermission $request): JsonResponse
    {
        $this->authorize("syncForSuperAdminRole", Auth::user());

        $role = Role::query()->find($request->role_id);

        if ($role) {
            $role->syncPermissions($request->permissions);
        }

        $notification = array(
            'message' => 'Permission Sync Successfully',
            'alert-type' => 'success',
            'code' => 200
        );

        return response()->json($notification);

    }

    public function permissions(Request $request): JsonResponse
    {
        $role = Role::query()->find($request->role_id);

        return response()->json([
            'permissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    public function rolePermissions(Request $request)
    {
        dd($request->all());
    }
}
