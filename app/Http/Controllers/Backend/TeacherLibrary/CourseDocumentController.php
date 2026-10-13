<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CourseDocumentRequest;
use App\Models\CourseDocument;
use App\Models\CurriculumCourse;
use App\Services\TeacherLibraryFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Step 4 — Course documents (curriculum map, weekly planning, term assessments).
 * Opened from the course hub. Files live on the private `local` disk.
 */
class CourseDocumentController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(CurriculumCourse $course): View
    {
        // $this->authorize('createCourseDocument', Auth::user());

        return view('backend.teacher-library.documents.form', [
            'course' => $course,
            'types'  => CourseDocumentRequest::TYPES,
            'terms'  => CourseDocumentRequest::TERMS,
        ]);
    }

    public function store(CourseDocumentRequest $request, CurriculumCourse $course): RedirectResponse
    {
        // $this->authorize('createCourseDocument', Auth::user());

        $data = $request->safe()->except('file');

        return $this->save('created', CourseDocument::class, null, function () use ($request, $course, $data) {
            $data += TeacherLibraryFileService::store(
                $request->file('file'),
                TeacherLibraryFileService::courseFolder($course->slug, 'documents'),
                $data['type']
            );
            $data['term'] = $data['type'] === 'term_assessment' ? $data['term'] : null;
            $data['sort_order'] ??= (int) $course->documents()->max('sort_order') + 1;

            return $course->documents()->create($data);
        }, 'Document added.', route('admin.teacher-library.courses.show', $course) . '#documents');
    }

    public function edit(CourseDocument $document): View
    {
        // $this->authorize('updateCourseDocument', Auth::user());

        return view('backend.teacher-library.documents.form', [
            'course' => $document->course,
            'item'   => $document,
            'types'  => CourseDocumentRequest::TYPES,
            'terms'  => CourseDocumentRequest::TERMS,
        ]);
    }

    public function update(CourseDocumentRequest $request, CourseDocument $document): RedirectResponse
    {
        // $this->authorize('updateCourseDocument', Auth::user());

        $data = $request->safe()->except('file');
        $before = clone $document;
        $course = $document->course;

        return $this->save('updated', CourseDocument::class, $before, function () use ($request, $document, $course, $data) {
            if ($request->hasFile('file')) {
                $oldPath = $document->file_path;
                $data += TeacherLibraryFileService::store(
                    $request->file('file'),
                    TeacherLibraryFileService::courseFolder($course->slug, 'documents'),
                    $data['type']
                );
                TeacherLibraryFileService::deleteAfterCommit($oldPath);   // only once the save has worked
            }
            $data['term'] = $data['type'] === 'term_assessment' ? $data['term'] : null;
            $data['sort_order'] ??= $document->sort_order;

            $document->update($data);

            return $document;
        }, 'Document updated.', route('admin.teacher-library.courses.show', $course) . '#documents');
    }

    public function destroy(CourseDocument $document): RedirectResponse
    {
        // $this->authorize('deleteCourseDocument', Auth::user());

        $before = clone $document;
        $course = $document->course;

        // Soft delete: the file stays on disk, so a mistaken delete can be restored.
        return $this->save('deleted', CourseDocument::class, $before, function () use ($document) {
            $document->delete();

            return $document;
        }, 'Document deleted.', route('admin.teacher-library.courses.show', $course) . '#documents');
    }

    /** Admin preview — streams the private file, never a public link. */
    public function file(CourseDocument $document): StreamedResponse
    {
        // $this->authorize('viewCourseDocument', Auth::user());

        return TeacherLibraryFileService::response($document->file_path, $document->title);
    }
}
