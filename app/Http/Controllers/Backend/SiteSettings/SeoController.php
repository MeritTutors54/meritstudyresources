<?php

namespace App\Http\Controllers\Backend\SiteSettings;

use App\Enums\SEOPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreSEORequest;
use App\Http\Requests\Backend\UpdateSEORequest;
use App\Models\Seo;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeoController extends Controller
{
    protected array $log;
    protected array $notice;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewSEO', Auth::user());

        $AllSeo = Seo::all();

        return view('backend.site-settings.seo.index')
            ->with([
                'AllSeo' => $AllSeo,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createSEO', Auth::user());

        $pages = SEOPage::filerPages();

        return view('backend.site-settings.seo.form')
            ->with([
                'pages' => $pages,
            ]);
    }

    public function store(StoreSEORequest $request): RedirectResponse
    {
        $this->authorize('createSEO', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Seo',
        ];

        DB::beginTransaction();
        try {
            $seo = Seo::query()->create($request->all());
            AdminActivity::track($this->log, $seo);

            $this->notice['message'] = 'Seo has been created.';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.seo-settings.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }

    public function edit(Seo $seo_setting): View
    {
        $this->authorize('updateSEO', $seo_setting);

        $pages [] = SEOPage::from($seo_setting->page_title);;

        return view('backend.site-settings.seo.form')
            ->with([
                'pages' => $pages,
                'seo_setting' => $seo_setting,
            ]);
    }

    public function update(UpdateSEORequest $request, Seo $seo_setting): RedirectResponse
    {
        $this->authorize('updateSEO', $seo_setting);

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Seo',
            'old_data' => json_encode($seo_setting->toArray()),
        ];

        DB::beginTransaction();
        try {
            $seo_setting->update($request->all());
            AdminActivity::track($this->log, $seo_setting);

            $this->notice['message'] = 'Seo has been updated';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.seo-settings.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }

    public function destroy(Seo $seo_setting): RedirectResponse
    {
        $this->authorize('deleteSEO', $seo_setting);

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Seo',
            'old_data' => json_encode($seo_setting->toArray()),
        ];

        DB::beginTransaction();
        try {
            $seo_setting->delete();
            AdminActivity::track($this->log);

            $this->notice['message'] = 'Seo has been deleted';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.seo-settings.index')
            ->with($this->notice['alert-type'], $this->notice['message']);
    }
}
