<?php

namespace App\Http\Controllers\Backend\PastPaper;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\UpdateCategoryRequest;
use App\Models\Category;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class CategoryController extends Controller
{

    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewPastPaperCategory', Auth::user());

        $categories = Category::query()->latest()->get();

        return view('backend.past-paper.category.index')
            ->with([
                'categories' => $categories,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createPastPaperCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.past-paper.category.form')
            ->with([
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->authorize('createPastPaperCategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Category',
        ];

        DB::beginTransaction();

        try {
            $category = Category::query()->create($request->all());
            AdminActivity::track($this->log, $category);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Category created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }


    public function edit(Category $category): View
    {
        $this->authorize('updatePastPaperCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.past-paper.category.form')
            ->with([
                'category' => $category,
                'statuses' => $statuses,
            ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {

        $this->authorize('updatePastPaperCategory', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Category',
            'old_data' => json_encode($category->toArray()),
        ];

        DB::beginTransaction();

        try {
            $category->update($request->all());

            AdminActivity::track($this->log, $category);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Category updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('deletePastPaperCategory', Auth::user());

        $log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Category',
            'old_data' => json_encode($category->toArray()),
        ];

        if ($category->subCategories()->count() > 0) {
            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = 'Category can not be deleted because it has subcategories';
        } else {
            DB::beginTransaction();

            try {
                $category->delete();
                AdminActivity::track($log);

                $this->notification['alert-type'] = 'success';
                $this->notification['message'] = 'Category deleted successfully';
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                $this->notification['message'] = $e->getMessage();
                $this->notification['alert-type'] = 'error';
            }
        }

        return to_route('admin.categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
