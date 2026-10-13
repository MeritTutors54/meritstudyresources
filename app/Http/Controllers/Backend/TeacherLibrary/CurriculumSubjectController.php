<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumSubjectRequest;
use App\Models\CurriculumSubject;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/** Step 3 — Subjects (Teacher Library admin). */
class CurriculumSubjectController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        // $this->authorize('viewCurriculumSubject', Auth::user());

        $subjectList = CurriculumSubject::query()
            ->withCount('courses')
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        return view('backend.teacher-library.subjects.index', ['items' => $subjectList]);
    }

    public function create(): View
    {
        // $this->authorize('createCurriculumSubject', Auth::user());

        return view('backend.teacher-library.subjects.form', [
        ]);
    }

    public function store(CurriculumSubjectRequest $request): RedirectResponse
    {
        // $this->authorize('createCurriculumSubject', Auth::user());

        $data = $request->validated();

        return $this->save('created', CurriculumSubject::class, null, function () use ($data) {
            $data['slug'] = UniqueSlugService::make(CurriculumSubject::class, $data['name']);
            $data['sort_order'] ??= (int) CurriculumSubject::query()->max('sort_order') + 1;

            return CurriculumSubject::query()->create($data);
        }, 'Subject created successfully.', route('admin.teacher-library.subjects.index'));
    }

    public function edit(CurriculumSubject $subject): View
    {
        // $this->authorize('updateCurriculumSubject', Auth::user());

        return view('backend.teacher-library.subjects.form', [
            'item' => $subject,
        ]);
    }

    public function update(CurriculumSubjectRequest $request, CurriculumSubject $subject): RedirectResponse
    {
        // $this->authorize('updateCurriculumSubject', Auth::user());

        $data = $request->validated();
        $before = clone $subject;

        return $this->save('updated', CurriculumSubject::class, $before, function () use ($data, $subject) {
            if ($data['name'] !== $subject->name) {
                $data['slug'] = UniqueSlugService::make(CurriculumSubject::class, $data['name'], $subject->id);
            }
            $data['sort_order'] ??= $subject->sort_order;

            $subject->update($data);

            return $subject;
        }, 'Subject updated successfully.', route('admin.teacher-library.subjects.index'));
    }

    public function destroy(CurriculumSubject $subject): RedirectResponse
    {
        // $this->authorize('deleteCurriculumSubject', Auth::user());

        if ($subject->courses()->exists()) {
            return $this->refuse(
                "\"{$subject->name}\" still has courses. Move or delete its courses first.",
                route('admin.teacher-library.subjects.index')
            );
        }

        $before = clone $subject;

        return $this->save('deleted', CurriculumSubject::class, $before, function () use ($subject) {
            $subject->delete();

            return $subject;
        }, 'Subject deleted successfully.', route('admin.teacher-library.subjects.index'));
    }
}
