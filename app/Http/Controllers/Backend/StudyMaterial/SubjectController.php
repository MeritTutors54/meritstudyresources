<?php

namespace App\Http\Controllers\Backend\StudyMaterial;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreSubjectRequest;
use App\Models\EducationLevel;
use App\Models\Subject;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SubjectController extends Controller
{
    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewStudyMaterialSubject', Auth::user());

        $subjects = Subject::all();

        return view('backend.study-material.subject.index')
            ->with([
                'subjects' => $subjects,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createStudyMaterialSubject', Auth::user());

        $statuses = Status::cases();

        $educationLevels = EducationLevel::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.study-material.subject.form')
            ->with([
                'statuses' => $statuses,
                'educationLevels' => $educationLevels,
            ]);
    }

    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $this->authorize('createStudyMaterialSubject', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Subject',
        ];

        DB::beginTransaction();

        try {
            $subject = Subject::query()->create($request->all());
            AdminActivity::track($this->log, $subject);

            $this->notification['message'] = 'Subject  was created.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->notification['message'] = $th->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(Subject $subject): View
    {
        $this->authorize('updateStudyMaterialSubject', Auth::user());

        $statuses = Status::cases();
        $educationLevels = EducationLevel::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.study-material.subject.form')
            ->with([
                'statuses' => $statuses,
                'educationLevels' => $educationLevels,
                'subject' => $subject,
            ]);
    }

    public function update(StoreSubjectRequest $request, Subject $subject): RedirectResponse
    {
        $this->authorize('updateStudyMaterialSubject', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Subject',
            'old_data' => json_encode($subject->toArray()),
        ];

        DB::beginTransaction();
        try {
            $subject->update($request->all());
            AdminActivity::track($this->log, $subject);

            $this->notification['message'] = 'Subject was updated.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $this->authorize('deleteStudyMaterialSubject', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Subject',
            'old_data' => json_encode($subject->toArray()),
        ];

        if ($subject->topics()->whereNull('deleted_at')->exists()) {
            $this->notification['message'] = "Subject has active topic cannot be deleted.";
            $this->notification['alert-type'] = 'error';

            return to_route('admin.subjects.index')
                ->with($this->notification['alert-type'], $this->notification['message']);
        }

        DB::beginTransaction();
        try {
            $subject->delete();
            AdminActivity::track($this->log, $subject);

            $this->notification['message'] = 'Subject was deleted.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
