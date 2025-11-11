<?php

namespace App\Http\Controllers\Backend\SiteSettings;

use App\Enums\SEOPage;
use App\Enums\Social;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreSEORequest;
use App\Http\Requests\Backend\StoreSocialRequest;
use App\Http\Requests\Backend\UpdateSEORequest;
use App\Models\Seo;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SocialController extends Controller
{
    protected array $log;
    protected array $notice;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewSocial', Auth::user());

        $socialLinks = \App\Models\Social::all();

        return view('backend.site-settings.social.index')
            ->with([
                'socialLinks' => $socialLinks,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createSocial', Auth::user());

        $socials = Social::cases();
        $statuses = Status::cases();

        return view('backend.site-settings.social.form')
            ->with([
                'socials' => $socials,
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreSocialRequest $request): RedirectResponse
    {
        $this->authorize('createSocial', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Social',
        ];

        DB::beginTransaction();
        try {
            $social = \App\Models\Social::query()->create($request->all());
            AdminActivity::track($this->log, $social);

            $this->notice['message'] = 'Social link has been created.';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.socials.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }

    public function edit(\App\Models\Social $social): View
    {
        $this->authorize('updateSocial', $social);

        $socials = Social::cases();
        $statuses = Status::cases();

        return view('backend.site-settings.social.form')
            ->with([
                'social' => $social,
                'socials' => $socials,
                'statuses' => $statuses,
            ]);
    }

    public function update(StoreSocialRequest $request, \App\Models\Social $social): RedirectResponse
    {
        $this->authorize('updateSocial', $social);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Social',
            'old_data' => json_encode($social->toArray()),
        ];

        DB::beginTransaction();
        try {
            $social->update($request->all());
            AdminActivity::track($this->log, $social);

            $this->notice['message'] = 'Social link has been updated';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.socials.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }

    public function destroy(\App\Models\Social $social): RedirectResponse
    {
        $this->authorize('deleteSocial', $social);

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Social',
            'old_data' => json_encode($social->toArray()),
        ];

        DB::beginTransaction();
        try {
            $social->delete();
            AdminActivity::track($this->log, $social);

            $this->notice['message'] = 'Social link has been deleted';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.socials.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }
}
