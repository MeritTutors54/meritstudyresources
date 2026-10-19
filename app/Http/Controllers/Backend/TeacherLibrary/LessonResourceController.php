<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\ReorderRequest;
use App\Http\Requests\Backend\TeacherLibrary\StoreLessonResourceRequest;
use App\Http\Requests\Backend\TeacherLibrary\UpdateLessonResourceRequest;
use App\Models\CurriculumLesson;
use App\Models\LessonResource;
use App\Models\LessonResourceType;
use App\Services\CurriculumNumberingService;
use App\Services\TeacherLibraryFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Step 7 — Lesson files (what teachers download). Listed and uploaded on the lesson page.
 * Files live on the private `local` disk; admins open them through file().
 */
class LessonResourceController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /** The upload form lives on the lesson page. */
    public function create(CurriculumLesson $lesson): RedirectResponse
    {
        // $this->authorize('createLessonResource', Auth::user());

        return redirect()->to(route('admin.teacher-library.lessons.show', $lesson) . '#upload');
    }

    /** One or more files in a single save; if any row fails, nothing is kept. */
    public function store(StoreLessonResourceRequest $request, CurriculumLesson $lesson): RedirectResponse
    {
        // $this->authorize('createLessonResource', Auth::user());

        $rows = $request->validated('files');
        $lesson->load('unit.course');
        $folder = TeacherLibraryFileService::courseFolder($lesson->unit->course->slug, $lesson->code);
        $typeSlugs = LessonResourceType::query()->pluck('slug', 'id');

        return $this->save('created', LessonResource::class, null, function () use ($request, $rows, $lesson, $folder, $typeSlugs) {
            $order = (int) $lesson->resources()->max('sort_order');
            $last = null;

            foreach ($rows as $i => $row) {
                $stored = TeacherLibraryFileService::store(
                    $request->file("files.$i.file"),
                    $folder,
                    $typeSlugs[$row['resource_type_id']] ?? 'file'
                );

                $last = $lesson->resources()->create([
                    'resource_type_id' => $row['resource_type_id'],
                    'title'            => $row['title'],
                    'is_paid'          => $row['is_paid'],
                    'is_pro'           => $row['is_pro'],
                    'sort_order'       => ++$order,
                    'status'           => 1,
                ] + $stored);
            }

            return $last;
        }, count($rows) === 1 ? '1 file uploaded.' : count($rows) . ' files uploaded.', route('admin.teacher-library.lessons.show', $lesson) . '#files');
    }

    public function edit(LessonResource $resource): View
    {
        // $this->authorize('updateLessonResource', Auth::user());

        $resource->load('lesson.unit.course');

        return view('backend.teacher-library.resources.form', [
            'item'   => $resource,
            'lesson' => $resource->lesson,
            'unit'   => $resource->lesson->unit,
            'course' => $resource->lesson->unit->course,
            'types'  => LessonResourceType::query()->orderBy('sort_order')->get(),
        ]);
    }

    /** Edit details; a new file replaces the old one but keeps the same row, so download history stays attached. */
    public function update(UpdateLessonResourceRequest $request, LessonResource $resource): RedirectResponse
    {
        // $this->authorize('updateLessonResource', Auth::user());

        $data = $request->safe()->except('file');
        $before = clone $resource;
        $lesson = $resource->lesson()->with('unit.course')->first();

        return $this->save('updated', LessonResource::class, $before, function () use ($request, $resource, $lesson, $data) {
            if ($request->hasFile('file')) {
                $oldPath = $resource->file_path;
                $data += TeacherLibraryFileService::store(
                    $request->file('file'),
                    TeacherLibraryFileService::courseFolder($lesson->unit->course->slug, $lesson->code),
                    LessonResourceType::query()->whereKey($data['resource_type_id'])->value('slug') ?? 'file'
                );
                TeacherLibraryFileService::deleteAfterCommit($oldPath);
            }

            $resource->update($data);

            return $resource;
        }, 'File updated.', route('admin.teacher-library.lessons.show', $lesson) . '#files');
    }

    /** Soft delete only: download history points at this row, and the report still needs its name. */
    public function destroy(LessonResource $resource): RedirectResponse
    {
        // $this->authorize('deleteLessonResource', Auth::user());

        $before = clone $resource;
        $lessonId = $resource->lesson_id;

        return $this->save('deleted', LessonResource::class, $before, function () use ($resource) {
            $resource->delete();

            return $resource;
        }, 'File deleted.', route('admin.teacher-library.lessons.show', $lessonId) . '#files');
    }

    /** PATCH lessons/{lesson}/resources/reorder — ids[] in the new order. */
    public function reorder(ReorderRequest $request, CurriculumLesson $lesson): RedirectResponse
    {
        // $this->authorize('updateLessonResource', Auth::user());

        return $this->save('reordered', CurriculumLesson::class, null, function () use ($request, $lesson) {
            CurriculumNumberingService::reorder(LessonResource::class, 'sort_order', ['lesson_id' => $lesson->id], $request->validated('ids'));

            return $lesson;
        }, 'File order saved.', route('admin.teacher-library.lessons.show', $lesson) . '#files');
    }

    /** Admin preview — streams the private file, never a public link. */
    public function file(LessonResource $resource): StreamedResponse
    {
        // $this->authorize('viewLessonResource', Auth::user());

        return TeacherLibraryFileService::response($resource->file_path, $resource->title);
    }
}
