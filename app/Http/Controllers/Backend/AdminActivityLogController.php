<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->query('admin_id') ?? null;

        $admins = Admin::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $activityLogs = AdminActivity::getActivityLogs($q);

        return view('backend.activity-log.index')
            ->with([
                'q' => $q,
                'admins' => $admins,
                'activityLogs' => $activityLogs
            ]);
    }
}
