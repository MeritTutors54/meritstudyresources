<?php

namespace App\Http\Controllers\Backend\SiteSettings;

use App\Enums\Rating;
use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreFAQRequest;
use App\Http\Requests\Backend\StoreTestimonialRequest;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Operations\Backend\AdminActivity;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    protected array $log;
    protected array $notice;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $this->authorize("viewTestimonial", Auth::user());

        $testimonials = Testimonial::query()->get();

        return view('backend.site-settings.testimonial.index')
            ->with([
                'testimonials' => $testimonials,
            ]);
    }


    public function create()
    {
        $this->authorize("createTestimonial", Auth::user());

        $types = UserType::cases();
        $ratings =  Rating::cases();

        return view('backend.site-settings.testimonial.form')
            ->with([
                'types' => $types,
                'ratings' => $ratings,
            ]);
    }

    public function store(StoreTestimonialRequest $request)
    {
        $this->authorize("createTestimonial", Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Testimonial',
        ];

        DB::beginTransaction();
        try {
            $faq = Testimonial::query()->create(request()->all());

            AdminActivity::track($this->log, $faq);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Testimonial added successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.testimonials.index')
            ->with($this->notice['type'], $this->notice['message']);
    }

    public function edit(Testimonial $testimonial)
    {
        $this->authorize("updateTestimonial", Auth::user());

        $types = UserType::cases();
        $ratings =  Rating::cases();

        return view('backend.site-settings.testimonial.form')->with([
            'testimonial' => $testimonial,
            'types' => $types,
            'ratings' => $ratings,
        ]);
    }

    public function update(StoreTestimonialRequest $request, Testimonial $testimonial)
    {
        $this->authorize("updateTestimonial", Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Testimonial',
            'old_data' => json_encode($testimonial->toArray()),
        ];

        DB::beginTransaction();
        try {
            $testimonial->update($request->all());

            AdminActivity::track($this->log, $testimonial);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Faq updated successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.testimonials.index')
            ->with($this->notice['type'], $this->notice['message']);
    }


    public function destroy(Testimonial $testimonial)
    {
        $this->authorize('deleteTestimonial', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Testimonial',
            'old_data' => json_encode($testimonial->toArray()),
        ];

        DB::beginTransaction();
        try {
            $testimonial->delete();

            AdminActivity::track($this->log, $testimonial);

            $this->notice['type'] = 'success';
            $this->notice['message'] = 'Testimonial deleted successfully.';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notice['message'] = $exception->getMessage();
            $this->notice['type'] = 'error';
        }

        return to_route('admin.testimonials.index')
            ->with($this->notice['type'], $this->notice['message']);
    }

}
