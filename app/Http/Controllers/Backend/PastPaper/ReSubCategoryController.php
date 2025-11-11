<?php

namespace App\Http\Controllers\Backend\PastPaper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreResubCategoryRequest;
use App\Http\Requests\Backend\UpdateResubCategoryRequest;
use App\Models\Category;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Operations\Backend\AdminActivity;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Str;
use Validator;

class ReSubCategoryController extends Controller
{

    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewPastPaperResubcategory', Auth::user());

        $allData = Resubcategory::query()
            ->with('category', 'subcategory')
            ->where('is_deleted', 0)->get();

        return view('backend.past-paper.resub-category.index')
            ->with([
                'allData' => $allData,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createPastPaperResubcategory', Auth::user());

        $allCategories = Category::query()
            ->select(['category_name', 'id'])->get();

        return view('backend.past-paper.resub-category.form')
            ->with([
                'allCategories' => $allCategories,
            ]);
    }

    public function store(StoreResubCategoryRequest $request): RedirectResponse
    {
        $this->authorize('createPastPaperResubcategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Resubcategory',
        ];

        DB::beginTransaction();
        try {
            $resubcategory = Resubcategory::query()->create($request->all());
            AdminActivity::track($this->log);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Resub Category Created Successfully';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.resub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function edit(Resubcategory $resub_category): View
    {
        $this->authorize('updatePastPaperResubcategory', Auth::user());

        $allCategories = Category::query()
            ->where('is_deleted', 0)->get();

        $subCategories = SubCategory::query()
            ->whereHas('category', function ($query) use ($resub_category) {
                $query->where('category_id', $resub_category->category_id);
            })->get();

        return view('backend.past-paper.resub-category.form')
            ->with([
                'resub_category' => $resub_category,
                'allCategories' => $allCategories,
                'subCategories' => $subCategories,
            ]);
    }

    public function update(UpdateResubCategoryRequest $request, Resubcategory $resub_category): RedirectResponse
    {
        $this->authorize('updatePastPaperResubcategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Resubcategory',
            'old_data' => json_encode($resub_category->toArray()),
        ];

        DB::beginTransaction();
        try {
            $resub_category->update($request->all());
            AdminActivity::track($this->log, $resub_category);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Resub Category Updated Successfully';
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.resub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);
    }


    public function destroy(Resubcategory $resub_category): RedirectResponse
    {
        $this->authorize('deletePastPaperResubcategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Resubcategory',
            'old_data' => json_encode($resub_category->toArray()),
        ];

        if ($resub_category->pastPapers()->count() > 0) {
            $this->notification['status'] = 'error';
            $this->notification['message'] = 'Resub-Category cannot be deleted cause it has Past-Papers';
        } else {
            DB::beginTransaction();
            try {
                $resub_category->delete();
                AdminActivity::track($this->log, $resub_category);

                $this->notification['status'] = 'success';
                $this->notification['message'] = 'Resub-Category Deleted Successfully';

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();

                $this->notification['status'] = 'error';
                $this->notification['message'] = $exception->getMessage();
            }
        }

        return to_route('admin.resub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);
    }
}
