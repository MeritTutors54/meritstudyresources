<?php

namespace App\Http\Controllers\Backend\StudyMaterial;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreEducationalLevelRequest;
use App\Http\Requests\Backend\UpdateEducationalLevelRequest;
use App\Models\EducationLevel;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EducationLevelController extends Controller
{
    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewEducationalLevel', Auth::user());

        $levels = EducationLevel::all();

        return view('backend.study-material.educational-level.index')
            ->with([
                'levels' => $levels,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createEducationalLevel', Auth::user());

        $statuses = Status::cases();

        return view('backend.study-material.educational-level.form')
            ->with([
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreEducationalLevelRequest $request): RedirectResponse
    {
        $this->authorize('createEducationalLevel', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\EducationLevel',
        ];

        DB::beginTransaction();

        try {
            $education = EducationLevel::query()->create($request->all());
            AdminActivity::track($this->log, $education);

            $this->notification['message'] = 'Educational level was created.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->notification['message'] = $th->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.educational-levels.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(EducationLevel $educational_level): View
    {
        $this->authorize('updateEducationalLevel', Auth::user());

        $statuses = Status::cases();

        return view('backend.study-material.educational-level.form')
            ->with([
                'statuses' => $statuses,
                'educational_level' => $educational_level,
            ]);
    }

    public function update(UpdateEducationalLevelRequest $request, EducationLevel $educational_level): RedirectResponse
    {
        $this->authorize('updateEducationalLevel', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\EducationLevel',
            'old_data' => json_encode($educational_level->toArray()),
        ];

        DB::beginTransaction();

        try {
            $educational_level->update($request->all());
            AdminActivity::track($this->log, $educational_level);

            $this->notification['message'] = 'Educational level was updated.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.educational-levels.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(EducationLevel $educational_level): RedirectResponse
    {
        $this->authorize('deleteEducationalLevel', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\EducationLevel',
            'old_data' => json_encode($educational_level->toArray()),
        ];

        if ($educational_level->whereNull('deleted_at')->exists()) {
            $this->notification['message'] = "Education Level has active subject and cannot be deleted";
            $this->notification['alert-type'] = 'error';

            return to_route('admin.educational-levels.index')
                ->with($this->notification['alert-type'], $this->notification['message']);
        }

        DB::beginTransaction();
        try {
            $educational_level->delete();
            AdminActivity::track($this->log, $educational_level);

            $this->notification['message'] = 'Education level was deleted.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.educational-levels.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
