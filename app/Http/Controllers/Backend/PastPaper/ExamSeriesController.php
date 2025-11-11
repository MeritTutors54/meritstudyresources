<?php

namespace App\Http\Controllers\Backend\PastPaper;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\StoreExamSeriesRequest;
use App\Http\Requests\Backend\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\PastPaperYear;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class ExamSeriesController extends Controller
{

    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewExamSeries', Auth::user());

        $pastPaperYears = PastPaperYear::query()->latest()->get();

        return view('backend.past-paper.exam-series.index')
            ->with([
                'series' => $pastPaperYears
            ]);
    }

    public function create(): View
    {
        $this->authorize('createExamSeries', Auth::user());

        $statuses = Status::cases();

        return view('backend.past-paper.exam-series.form')
            ->with([
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreExamSeriesRequest $request): RedirectResponse
    {
        $this->authorize('createExamSeries', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\PastPaperYear',
        ];

        DB::beginTransaction();

        try {
            $pastPaperYear = PastPaperYear::query()->create($request->all());
            AdminActivity::track($this->log, $pastPaperYear);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Exam Series created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.exam-series.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }


    public function edit(PastPaperYear $exam_series): View
    {
        $this->authorize('updateExamSeries', Auth::user());

        $statuses = Status::cases();

        return view('backend.past-paper.exam-series.form')
            ->with([
                'year' => $exam_series,
                'statuses' => $statuses,
            ]);
    }

    public function update(StoreExamSeriesRequest $request, PastPaperYear $exam_series): RedirectResponse
    {

        $this->authorize('updateExamSeries', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\PastPaperYear',
            'old_data' => json_encode($exam_series->toArray()),
        ];

        DB::beginTransaction();

        try {
            $exam_series->update($request->all());

            AdminActivity::track($this->log, $exam_series);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Exam Series updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.exam-series.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(PastPaperYear $exam_series): RedirectResponse
    {
        $this->authorize('deleteExamSeries', Auth::user());

        $log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\PastPaperYear',
            'old_data' => json_encode($exam_series->toArray()),
        ];

        if ($exam_series->isUsed()->count() > 0) {
            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = 'Exam series can not be deleted because it has been used in past paper';
        } else {
            DB::beginTransaction();

            try {
                $exam_series->delete();
                AdminActivity::track($log);

                $this->notification['alert-type'] = 'success';
                $this->notification['message'] = 'Exam series deleted successfully';
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                $this->notification['message'] = $e->getMessage();
                $this->notification['alert-type'] = 'error';
            }
        }

        return to_route('admin.exam-series.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
