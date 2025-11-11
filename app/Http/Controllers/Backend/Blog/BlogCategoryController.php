<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBlogCategoryRequest;
use App\Models\AdminActivityLog;
use App\Models\BlogCategory;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewBlogCategory', Auth::user());

        $blogCategories = BlogCategory::query()->latest()->get();

        return view('backend.blogs.categories.index')
            ->with([
                'blogCategories' => $blogCategories
            ]);
    }

    public function create(): View
    {
        $this->authorize('createBlogCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.blogs.categories.form')
            ->with([
                'statuses' => $statuses
            ]);
    }

    public function store(StoreBlogCategoryRequest $request): RedirectResponse
    {
        $this->authorize('createBlogCategory', Auth::user());

        $notification = [
            'message' => '',
            'alert-type' => '',
        ];

        $log = [
            'action' => 'created',
            'model_type' => 'App\Models\BlogCategory',
        ];

        DB::beginTransaction();

        try {
            $blogCategory = BlogCategory::query()->create($request->all());
            AdminActivity::track($log, $blogCategory);

            $notification['alert-type'] = 'success';
            $notification['message'] = 'Blog category created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notification['message'] = $e->getMessage();
            $notification['alert-type'] = 'error';
        }

        return to_route('admin.blog-categories.index')
            ->with($notification['alert-type'], $notification['message']);
    }

    public function edit(BlogCategory $blogCategory): View
    {
        $this->authorize('editBlogCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.blogs.categories.form')
            ->with([
                'blogCategory' => $blogCategory,
                'statuses' => $statuses
            ]);
    }

    public function update(StoreBlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        $this->authorize('editBlogCategory', Auth::user());

        $notification = [
            'message' => '',
            'alert-type' => '',
        ];

        $log = [
            'action' => 'updated',
            'model_type' => 'App\Models\BlogCategory',
            'old_data' => json_encode($blogCategory->toArray()),
        ];

        DB::beginTransaction();

        try {
            $blogCategory->update($request->all());
            AdminActivity::track($log, $blogCategory);

            $notification['alert-type'] = 'success';
            $notification['message'] = 'Blog category updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notification['message'] = $e->getMessage();
            $notification['alert-type'] = 'error';
        }

        return to_route('admin.blog-categories.index')
            ->with($notification['alert-type'], $notification['message']);
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $this->authorize('deleteBlogCategory', Auth::user());

        $notification = [
            'message' => '',
            'alert-type' => '',
        ];

        $log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\BlogCategory',
            'old_data' => json_encode($blogCategory->toArray()),
        ];

        DB::beginTransaction();

        try {
            $blogCategory->delete();
            AdminActivity::track($log);

            $notification['alert-type'] = 'success';
            $notification['message'] = 'Blog category deleted successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notification['message'] = $e->getMessage();
            $notification['alert-type'] = 'error';
        }

        return to_route('admin.blog-categories.index')
            ->with($notification['alert-type'], $notification['message']);
    }
}
