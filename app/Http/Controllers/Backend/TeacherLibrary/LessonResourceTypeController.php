<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\LessonResourceTypeRequest;
use App\Models\LessonResourceType;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/** Step 3 — File types (Teacher Library admin). */
class LessonResourceTypeController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        // $this->authorize('viewLessonResourceType', Auth::user());

        $resourceTypeList = LessonResourceType::query()
            ->withCount('resources')
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        return view('backend.teacher-library.resource-types.index', ['items' => $resourceTypeList]);
    }

    public function create(): View
    {
        // $this->authorize('createLessonResourceType', Auth::user());

        return view('backend.teacher-library.resource-types.form', [
        ]);
    }

    public function store(LessonResourceTypeRequest $request): RedirectResponse
    {
        // $this->authorize('createLessonResourceType', Auth::user());

        $data = $request->validated();

        return $this->save('created', LessonResourceType::class, null, function () use ($data) {
            $data['slug'] = UniqueSlugService::make(LessonResourceType::class, $data['name']);
            $data['sort_order'] ??= (int) LessonResourceType::query()->max('sort_order') + 1;

            return LessonResourceType::query()->create($data);
        }, 'File type created successfully.', route('admin.teacher-library.resource-types.index'));
    }

    public function edit(LessonResourceType $resource_type): View
    {
        // $this->authorize('updateLessonResourceType', Auth::user());

        return view('backend.teacher-library.resource-types.form', [
            'item' => $resource_type,
        ]);
    }

    public function update(LessonResourceTypeRequest $request, LessonResourceType $resource_type): RedirectResponse
    {
        // $this->authorize('updateLessonResourceType', Auth::user());

        $data = $request->validated();
        $before = clone $resource_type;

        return $this->save('updated', LessonResourceType::class, $before, function () use ($data, $resource_type) {
            if ($data['name'] !== $resource_type->name) {
                $data['slug'] = UniqueSlugService::make(LessonResourceType::class, $data['name'], $resource_type->id);
            }
            $data['sort_order'] ??= $resource_type->sort_order;

            $resource_type->update($data);

            return $resource_type;
        }, 'File type updated successfully.', route('admin.teacher-library.resource-types.index'));
    }

    public function destroy(LessonResourceType $resource_type): RedirectResponse
    {
        // $this->authorize('deleteLessonResourceType', Auth::user());

        if ($resource_type->resources()->exists()) {
            return $this->refuse(
                "\"{$resource_type->name}\" still has lesson files. Change those files to another type first.",
                route('admin.teacher-library.resource-types.index')
            );
        }

        $before = clone $resource_type;

        return $this->save('deleted', LessonResourceType::class, $before, function () use ($resource_type) {
            $resource_type->delete();

            return $resource_type;
        }, 'File type deleted successfully.', route('admin.teacher-library.resource-types.index'));
    }
}
