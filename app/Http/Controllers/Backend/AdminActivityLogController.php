<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivityLog;
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


        return view('backend.activity-log.index')
            ->with([
                'q' => $q,
                'admins' => $admins,
            ]);
    }

    public function show(AdminActivityLog $activityLog): View
    {
        $modelName = AdminActivity::splitStudlyCaseToWords($activityLog->model_type);
        $old = $this->excludeUnwanted(json_decode($activityLog->old_data, true));
        $new = $this->excludeUnwanted(json_decode($activityLog->new_data, true));

        $diffStuff = [];


        if (!empty($new) && !empty($old)) {
            foreach ($new as $key => $value) {
                if (!array_key_exists($key, $old) || $old[$key] !== $value) {
                    $diffStuff[$key] = [
                        'old' => $old[$key] ?? null,
                        'new' => $value
                    ];
                }
            }
        }

        return view('backend.activity-log.show')
            ->with([
                'log' => $activityLog,
                'model' => $modelName,
                'old' => $old,
                'new' => $new,
                'diffStuff' => $diffStuff
            ]);
    }

    public function excludeUnwanted($object)
    {
        $excludeKeys = ['created_at', 'updated_at', 'deleted_at'];

        if (!empty($object)) {
            foreach ($excludeKeys as $key) {
                unset($object[$key]);
            }
        }

        return $object;
    }
}
