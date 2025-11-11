<?php

namespace App\Http\Controllers\Backend\Ecommerce;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBookSubjectRequest;
use App\Http\Requests\Backend\UpdateBookSubjectRequest;
use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Operations\Backend\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookSubjectController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewBookSubject', Auth::user());

        $bookSubjects = BookSubject::all();

        return view('backend.ecommerce.subject.index')
            ->with([
                'bookSubjects' => $bookSubjects,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createBookSubject', Auth::user());

        $statuses = Status::cases();

        $bookCategories = BookCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.ecommerce.subject.form')
            ->with([
                'bookCategories' => $bookCategories,
                'statuses' => $statuses,
            ]);
    }

    public function store(StoreBookSubjectRequest $request): RedirectResponse
    {
        $this->authorize('createBookSubject', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\BookSubject',
        ];

        DB::beginTransaction();

        try {
            $bookSubCategory = BookSubject::query()->create($request->all());
            AdminActivity::track($this->log, $bookSubCategory);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Sub Category created successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(BookSubject $book_subject): View
    {
        $this->authorize('updateBookSubject', Auth::user());

        $statuses = Status::cases();
        $bookCategories = BookCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.ecommerce.subject.form')
            ->with([
                'book_subject' => $book_subject,
                'bookCategories' => $bookCategories,
                'statuses' => $statuses,
            ]);
    }

    public function update(UpdateBookSubjectRequest $request, BookSubject $book_subject): RedirectResponse
    {
        $this->authorize('updateBookSubject', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\BookSubject',
            'old_data' => json_encode($book_subject->toArray()),
        ];

        DB::beginTransaction();

        try {
            $book_subject->update($request->all());
            AdminActivity::track($this->log, $book_subject);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Sub Category updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(BookSubject $book_subject): RedirectResponse
    {
        $this->authorize('deleteBookSubject', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\BookSubject',
            'old_data' => json_encode($book_subject->toArray()),
        ];

//        if ($book_sub_category->books()->exists()) {
//            $this->notification['alert-type'] = 'error';
//            $this->notification['message'] = 'Sub category has active books and cannot be deleted';
//        }

        DB::beginTransaction();

        try {
            $book_subject->delete();
            AdminActivity::track($this->log, $book_subject);

            $this->notification['alert-type'] = 'success';
            $this->notification['message'] = 'Sub Category updated successfully';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['alert-type'] = 'error';
            $this->notification['message'] = $e->getMessage();
        }

        return to_route('admin.book-subjects.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
