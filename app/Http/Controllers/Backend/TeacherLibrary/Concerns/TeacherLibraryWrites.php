<?php

namespace App\Http\Controllers\Backend\TeacherLibrary\Concerns;

use App\Operations\Backend\AdminActivity;
use App\Services\TeacherLibraryFileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * The save routine every Teacher Library admin screen uses:
 * transaction → work → activity log → commit → flash message.
 * On failure: roll back, remove any files stored during the save,
 * log the real error and show the admin a plain message (no SQL / paths).
 */
trait TeacherLibraryWrites
{
    /**
     * @param  string  $action  created | updated | deleted | reordered ...
     * @param  class-string<Model>  $modelType
     * @param  Model|null  $before  the record before the change (for old_data), null on create
     * @param  callable(): Model  $work  does the change and returns the model to log
     * @param  string|\Closure(Model): string  $redirectTo  a URL, or a function that gets the saved model
     */
    protected function save(
        string $action,
        string $modelType,
        ?Model $before,
        callable $work,
        string $successMessage,
        string|\Closure $redirectTo
    ): RedirectResponse {
        $log = ['action' => $action, 'model_type' => $modelType];

        if ($before) {
            $log['old_data'] = json_encode($before->toArray());
        }

        DB::beginTransaction();

        try {
            $model = $work();
            AdminActivity::track($log, $model);

            DB::commit();
            TeacherLibraryFileService::keepStored();

            $url = $redirectTo instanceof \Closure ? $redirectTo($model) : $redirectTo;

            return redirect($url)->with('success', $successMessage);
        } catch (\Throwable $e) {
            DB::rollBack();
            TeacherLibraryFileService::discardStored();

            if ($e instanceof ValidationException) {
                throw $e;   // shown next to the form like any other validation error
            }

            Log::error('Teacher Library admin: ' . $action . ' ' . class_basename($modelType) . ' failed', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile() . ':' . $e->getLine(),
            ]);

            return back()->withInput()
                ->with('error', 'Something went wrong while saving. Nothing was changed — please try again.');
        }
    }

    /** Stop with a clear message (used for "can't delete while it has children"). */
    protected function refuse(string $message, string $redirectTo): RedirectResponse
    {
        return redirect($redirectTo)->with('error', $message);
    }
}
