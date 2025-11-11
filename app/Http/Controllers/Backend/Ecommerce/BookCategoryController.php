<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBookCategoryRequest;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\UpdateBookCategoryRequest;
use App\Models\BookCategory;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookCategoryController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewBookCategory', Auth::user());

        $bookCategories = BookCategory::all();

        return view('backend.ecommerce.category.index')
            ->with([
                'bookCategories' => $bookCategories,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createBookCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.ecommerce.category.form')
            ->with([
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreBookCategoryRequest $request): RedirectResponse
    {
        $this->authorize('createBookCategory', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\BookCategory',
        ];

        DB::beginTransaction();

        try {
            $bookCategory = BookCategory::query()->create($request->all());
            AdminActivity::track($this->log, $bookCategory);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Category created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(BookCategory $book_category): View
    {
        $this->authorize('updateBookCategory', Auth::user());

        $statuses = Status::cases();

        return view('backend.ecommerce.category.form')
            ->with([
                'book_category' => $book_category,
                'statuses' => $statuses,
            ]);
    }

    public function update(UpdateBookCategoryRequest $request, BookCategory $book_category): RedirectResponse
    {
        $this->authorize('updateBookCategory', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\BookCategory',
            'old_data' => json_encode($book_category->toArray()),
        ];

        DB::beginTransaction();

        try {
            $book_category->update($request->all());
            AdminActivity::track($this->log, $book_category);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Category updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(BookCategory $book_category): RedirectResponse
    {
        $this->authorize('deleteBookCategory', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\BookCategory',
            'old_data' => json_encode($book_category->toArray()),
        ];

        if ($book_category->books()->exists()) {
            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = 'Book category has active book sub categories and cannot be deleted';

            return to_route('admin.book-categories.index')
                ->with($this->notification['alert-type'], $this->notification['message']);
        }

        DB::beginTransaction();

        try {
            $book_category->delete();
            AdminActivity::track($this->log, $book_category);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Book category deleted successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-categories.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
