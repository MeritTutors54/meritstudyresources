<?php

namespace App\Http\Controllers\Backend\Policiy;

use App\Enums\Policy;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StorePolicyRequest;
use App\Models\PolicySettings;
use App\Operations\Backend\AdminActivity;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PolicyController extends Controller
{
    protected array $log;
    protected array $notification;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewPolicy', Auth::user());

        $policies = PolicySettings::all();

        return view('backend.policy.index')
            ->with([
                'policies' => $policies
            ]);
    }

    public function create(): View
    {
        $this->authorize('createPolicy', Auth::user());

        $policies = Policy::cases();
        $statuses = Status::cases();

        return view('backend.policy.form')
            ->with([
                'statuses' => $statuses,
                'policies' => $policies,
            ]);
    }

    public function store(StorePolicyRequest $request): RedirectResponse
    {
        $this->authorize('createPolicy', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Policy',
        ];

        DB::beginTransaction();
        try {
            $policy = PolicySettings::query()->create($request->except('_token', '_method'));
            AdminActivity::track($this->log, $policy);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Policy has been created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();


            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.policies.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(PolicySettings $policy): View
    {
        $this->authorize('updatePolicy', Auth::user());

        $policies = Policy::cases();
        $statuses = Status::cases();

        return view('backend.policy.form')
            ->with([
                'statuses' => $statuses,
                'policies' => $policies,
                'policy' => $policy,
            ]);
    }

    public function update(StorePolicyRequest $request, PolicySettings $policy): RedirectResponse
    {
        $this->authorize('updatePolicy', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Policy',
            'old_data' => json_encode($policy->toArray()),
        ];

        DB::beginTransaction();
        try {
            $policy->update($request->all());
            AdminActivity::track($this->log, $policy);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Policy has been updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.policies.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(PolicySettings $policy): RedirectResponse
    {
        $this->authorize('deletePolicy', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Policy',
            'old_data' => json_encode($policy->toArray()),
        ];

        DB::beginTransaction();
        try {
            $policy->delete();
            AdminActivity::track($this->log);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Policy has been deleted successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.policies.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
