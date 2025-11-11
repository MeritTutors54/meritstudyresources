<?php

namespace App\Http\Controllers\Backend\SiteSettings;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreFAQRequest;
use App\Models\Faq;
use App\Operations\Backend\AdminActivity;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    protected array $log;
    protected array $notice;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $this->authorize('viewFAQ', Auth::user());

        $faqs = Faq::query()
            ->where('status', 1)->get();

        return view('backend.site-settings.faq.index')
            ->with([
                'faqs' => $faqs,
            ]);
    }


    public function create()
    {
        $this->authorize('createFAQ', Auth::user());

        $statuses = Status::cases();

        return view('backend.site-settings.faq.form')
            ->with([
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreFAQRequest $request)
    {
        $this->authorize('createFAQ', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Faq',
        ];

        DB::beginTransaction();
        try {
            $faq = Faq::query()->create(request()->all());

            AdminActivity::track($this->log, $faq);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Faq added successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.faqs.index')
            ->with($this->notice['type'], $this->notice['message']);
    }

    public function edit(Faq $faq)
    {
        $this->authorize('updateFAQ', Auth::user());

        return view('backend.site-settings.faq.form')->with([
            'faq' => $faq,
            'statuses' => Status::cases(),
        ]);
    }

    public function update(StoreFAQRequest $request, Faq $faq)
    {
        $this->authorize('updateFAQ', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Faq',
            'old_data' => json_encode($faq->toArray()),
        ];

        DB::beginTransaction();
        try {
            $faq->update($request->all());

            AdminActivity::track($this->log, $faq);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Faq updated successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.faqs.index')
            ->with($this->notice['type'], $this->notice['message']);
    }


    public function destroy(Faq $faq)
    {
        $this->authorize('deleteFAQ', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Faq',
            'old_data' => json_encode($faq->toArray()),
        ];

        DB::beginTransaction();
        try {
            $faq->delete();

            AdminActivity::track($this->log, $faq);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Faq deleted successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.faqs.index')
            ->with($this->notice['type'], $this->notice['message']);
    }

}
