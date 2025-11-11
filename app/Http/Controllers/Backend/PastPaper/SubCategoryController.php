<?php

namespace App\Http\Controllers\Backend\PastPaper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreSubCategoryRequest;
use App\Http\Requests\Backend\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Operations\Backend\AdminActivity;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
{
    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $this->authorize('viewPastPaperSubcategory', Auth::user());

        $allData = SubCategory::query()
            ->where('is_deleted', 0)
            ->get();

        return view('backend.past-paper.sub-category.index')
            ->with([
                'allData' => $allData,
            ]);
    }


    public function create()
    {
        $this->authorize('createPastPaperSubcategory', Auth::user());

        $allCategory = Category::query()
            ->where('is_deleted', 0)->get();

        return view('backend.past-paper.sub-category.form')
            ->with([
                'allCategory' => $allCategory,
            ]);
    }


    public function store(StoreSubCategoryRequest $request)
    {
        $this->authorize('createPastPaperSubcategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\SubCategory',
        ];

        DB::beginTransaction();
        try {
            $subCategory = SubCategory::query()->create($request->all());

            AdminActivity::track($this->log);

            $this->notification['status'] = "success";
            $this->notification['message'] = "Sub Category created successfully";

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = "error";
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.sub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);

    }

    public function edit(SubCategory $sub_category)
    {
        $this->authorize('updatePastPaperSubcategory', Auth::user());

        $allCategory = Category::query()
            ->where('is_deleted', 0)->get();

        return view('backend.past-paper.sub-category.form')
            ->with([
                'sub_category' => $sub_category,
                'allCategory' => $allCategory,
            ]);
    }

    public function update(UpdateSubCategoryRequest $request, SubCategory $sub_category)
    {
        $this->authorize('updatePastPaperSubcategory', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\SubCategory',
            'old_data' => json_encode($sub_category->toArray()),
        ];

        DB::beginTransaction();
        try {
            $sub_category->update($request->all());
            AdminActivity::track($this->log, $sub_category);

            $this->notification['status'] = "success";
            $this->notification['message'] = "Sub Category updated successfully";

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = "error";
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.sub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function destroy(SubCategory $sub_category)
    {
        $this->authorize('deletePastPaperSubcategory', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\SubCategory',
            'old_data' => json_encode($sub_category->toArray()),
        ];


        if ($sub_category->resubcategories()->count() > 0) {
            $this->notification['status'] = "error";
            $this->notification['message'] = "Sub Category can't be deleted because it has resubcategories";
        } else {
            DB::beginTransaction();
            try {
                $sub_category->delete();
                AdminActivity::track($this->log, $sub_category);

                $this->notification['status'] = "success";
                $this->notification['message'] = "Sub Category deleted successfully";

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();

                $this->notification['status'] = "error";
                $this->notification['message'] = $exception->getMessage();
            }
        }

        return to_route('admin.sub-categories.index')
            ->with($this->notification['status'], $this->notification['message']);
    }
}
