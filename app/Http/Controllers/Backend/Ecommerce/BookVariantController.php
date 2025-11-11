<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBookSubCategoryRequest;
use App\Http\Requests\Backend\StoreBookSubjectRequest;
use App\Http\Requests\Backend\StoreBookVariantRequest;
use App\Http\Requests\Backend\UpdateBookSubCategoryRequest;
use App\Http\Requests\Backend\UpdateBookSubjectRequest;
use App\Http\Requests\Backend\UpdateBookVariantRequest;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Models\BookVariant;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookVariantController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewBookVariant', Auth::user());

        $variants = BookVariant::all();

        return view('backend.ecommerce.variant.index')
            ->with([
                'variants' => $variants,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createBookVariant', Auth::user());

        $statuses = Status::cases();

        $bookCategories = BookCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $bookSubjects = BookSubject::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.ecommerce.variant.form')
            ->with([
                'bookCategories' => $bookCategories,
                'bookSubjects' => $bookSubjects,
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreBookVariantRequest $request): RedirectResponse
    {
        $this->authorize('createBookVariant', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\BookVariant',
        ];

        DB::beginTransaction();

        try {
            $bookSubCategory = BookVariant::query()->create($request->all());
            AdminActivity::track($this->log, $bookSubCategory);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Book variant created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-variants.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(BookVariant $book_variant): View
    {
        $this->authorize('updateBookVariant', Auth::user());

        $statuses = Status::cases();

        $bookCategories = BookCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $bookSubjects = BookSubject::query()
            ->where('status', Status::ACTIVE->value)
            ->get();


        return view('backend.ecommerce.variant.form')
            ->with([
                'book_variant' => $book_variant,
                'bookCategories' => $bookCategories,
                'bookSubjects' => $bookSubjects,
                'statuses' => $statuses,
            ]);
    }

    public function update(UpdateBookVariantRequest $request, BookVariant $book_variant): RedirectResponse
    {
        $this->authorize('updateBookVariant', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\BookVariant',
            'old_data' => json_encode($book_variant->toArray()),
        ];

        DB::beginTransaction();

        try {
            $book_variant->update($request->all());
            AdminActivity::track($this->log, $book_variant);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Book variant updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-variants.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(BookVariant $book_variant): RedirectResponse
    {
        $this->authorize('deleteBookVariant', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\BookVariant',
            'old_data' => json_encode($book_variant->toArray()),
        ];

//        if ($book_sub_category->books()->exists()) {
//            $this->notification['alert-type'] = 'error';
//            $this->notification['message'] = 'Sub category has active books and cannot be deleted';
//        }

        DB::beginTransaction();

        try {
            $book_variant->delete();
            AdminActivity::track($this->log, $book_variant);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Book variant deleted successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-variants.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
