<?php

namespace App\Http\Controllers\Backend\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdateSiteSettingsRequest;
use App\Models\Contact;
use App\Models\SiteSettings;
use App\Models\SubscribeEmail;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingsController extends Controller
{
    protected array $log;
    protected array $notice;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function edit(): View
    {
        $this->authorize('viewSiteSettings', Auth::user());

        $siteSettings = SiteSettings::query()->first();
        $view = 'site-settings';

        return view('backend.site-settings.form')->with([
            'siteSettings' => $siteSettings,
            'view' => $view,
        ]);
    }

    public function update(UpdateSiteSettingsRequest $request, SiteSettings $siteSettings): RedirectResponse
    {
        $this->authorize('updateSiteSettings', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\SiteSettings',
            'old_data' => json_encode($siteSettings->toArray()),
        ];

        DB::beginTransaction();
        try {
            $siteSettings->update($request->except('_token'));
            AdminActivity::track($this->log, $siteSettings);

            $this->notice['message'] = 'Site Settings Updated Successfully';
            $this->notice['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['alert-type'] = 'error';
        }

        return to_route('admin.site.settings')
            ->with($this->notice['alert-type'], $this->notice['message']);

    }

    public function newsletterEmails()
    {
        $this->authorize('viewNewsLatter', Auth::user());

        $newsLetter = SubscribeEmail::query()->get();

        return view('backend.site-settings.news-letter')
            ->with([
                'newsLetter' => $newsLetter,
            ]);
    }

    public function customersInquiry()
    {
        $this->authorize('viewInquires', Auth::user());

        $contacts = Contact::query()->latest()->get();

        return view('backend.customer-inquiry.index')
            ->with([
                'contacts' => $contacts
            ]);
    }
}
