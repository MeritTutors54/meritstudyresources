<?php

namespace App\Operations\Backend;

use App\Enums\Status;
use App\Models\AdminActivityLog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

final class AdminActivity
{
    public static function splitStudlyCaseToWords(string $class): string
    {
        // Extract the base class name (remove namespace)
        $baseName = class_basename($class);

        // Insert space before each capital letter except the first
        return trim(preg_replace('/(?<!^)([A-Z])/', ' $1', $baseName));
    }

    public static function getActivityLogs(int $adminID = null, int $limit = -1)
    {
        $result = AdminActivityLog::query()
            ->with('admin')
            ->latest();

        if ($adminID) {
            $result->where('admin_id', $adminID);
        }

        if ($limit !== -1) {
            $result->take($limit);
        }

        return $result->get()->map(function ($log) {
            $log->name = $log->admin->name;
            $excludeKeys = ['created_at', 'updated_at', 'deleted_at'];
            $new_data = !empty($log->new_data) ? json_decode($log->new_data, true) : null;
            if (!empty($new_data)) {
                foreach ($excludeKeys as $key) {
                    unset($new_data[$key]);
                }
                $log->new_data = $new_data;
            }

            $old_data = !empty($log->old_data) ? json_decode($log->old_data, true) : null;
            if (!empty($old_data)) {
                foreach ($excludeKeys as $key) {
                    unset($old_data[$key]);
                }
                $log->old_data = $old_data;
            }

            $log->model_type = self::splitStudlyCaseToWords($log->model_type);

            return $log;
        });
    }

    public static function track(
        array $log,
        $modelValue = null
    ): void
    {
        AdminActivityLog::query()->create([
            'admin_id' => Auth::id(),
            'action' => $log['action'],
            'model_type' => $log['model_type'],
            'model_id' => !empty($modelValue) ? $modelValue->id : null,
            'old_data' => $log['old_data'] ?? null,
            'new_data' => !empty($modelValue) ? json_encode($modelValue->toArray()) : null,
        ]);
    }
}
