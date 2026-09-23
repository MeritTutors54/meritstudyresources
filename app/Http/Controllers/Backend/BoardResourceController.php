<?php

namespace App\Http\Controllers\Backend;

// use App\Enums\DifficultyType;
// use App\Enums\ResourceType;
// use App\Enums\Status;
// use App\Http\Controllers\Controller;
// use App\Models\BoardResource;
// use App\Models\BoardResourceFile;
// use App\Models\Resubcategory;
// use App\Models\SubCategory;
// use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
// use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;



use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminBoardResourceRequest;
// use App\Http\Requests\Backend\BoardResource\UpdateBoardResourceRequest;
use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\BoardResourceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoardResourceController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected BoardResourceRepositoryInterface $boardResourceRepository,
        protected BoardResourceService $boardResourceService,
    ) {}

    public function index(Request $request): View
    {
        $data = [];

        if ($this->hasResourceFilters($request)) {
            $data = $this->boardResourceRepository->getIndexData(
                categoryId: $request->integer('category'),
                subcategoryId: $request->integer('subcategory'),
                resubcategoryId: $request->integer('resubcategory_id'),
            );
        }

        return view('backend.resource.index', [
            'categories' => $this->categoryRepository->activeCategories(),
            'data' => $data,
        ]);
    }


    public function create(): View
    {
        return view('backend.resource.form', [
            'categories' => $this->categoryRepository->activeCategories(),
            'resourceTypes' => $this->boardResourceRepository->resourceTypes(),
            'difficulties' => $this->boardResourceRepository->difficulties(),
        ]);
    }

    public function store(AdminBoardResourceRequest $request): RedirectResponse
    {
       $boardResource = $this->boardResourceService->create($request->validated());

        return to_route('admin.board-resources.index', [
            'category' => $boardResource->examBoard->category_id,
            'subcategory' => $boardResource->examBoard->subcategory_id,
            'resubcategory_id' => $boardResource->resubcategory_id,
        ])->with('success', 'Resource created successfully.');
    }


    // public function create()
    // {
    //     $categories = $this->categoryRepository->activeCategories();

    //     $resourceTypes = ResourceType::options();

    //     $difficulties = DifficultyType::options();

    //     return view('backend.resource.form')->with([
    //         'categories' => $categories,
    //         'resourceTypes' => $resourceTypes,
    //         'difficulties' => $difficulties,
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'resubcategory_id' => ['required', 'exists:resubcategories,id'],
    //         'name' => ['nullable', 'string', 'max:255'],
    //         'resource_type' => ['required', Rule::enum(ResourceType::class)],
    //         'parent_id' => ['nullable', 'exists:board_resources,id'],
    //         'is_group' => ['required', 'boolean'],
    //         'is_paid' => ['required', 'boolean'],
    //         'is_active' => ['required', Rule::enum(Status::class)],
    //         'is_section_title' => ['required', 'boolean'],
    //         'file_orientation' => ['nullable', 'in:1,2'],
    //         'allow_files' => ['required', 'boolean'],


    //         'uploads'              => ['nullable', 'array', 'min:1'],
    //         'uploads.*.is_pro'     => ['nullable', 'in:0,1'],
    //         'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class)],
    //         'uploads.*.pdfFile'    => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
    //     ]);

    //     $parent = BoardResource::query()->find($validatedData['parent_id'] ?? null);

    //     if ($parent && $parent->resource_type != $validatedData['resource_type']) {
    //         return back()->with('error', 'the current resource type is different from parent resource type.');
    //     }


    //     $boardResource = BoardResource::query()->create($validatedData);

    //     if (isset($validatedData['uploads'])) {
    //         foreach ($validatedData['uploads'] as $index => $upload) {
    //             if (isset($upload['pdfFile'])) {
    //                 $file = $upload['pdfFile'];

    //                 // Get the original file name (without extension) and extension
    //                 $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //                 $extension = $file->getClientOriginalExtension();

    //                 // Create a unique file name using a timestamp and the original name
    //                 $fileName = time() . '_' . \Illuminate\Support\Str::slug($originalName) . '.' . $extension;

    //                 // Store the file in the 'public/pdfs' directory with the custom name
    //                 $path = $file->storeAs('board-resource', $fileName, 'public');

    //                 BoardResourceFile::query()->create([
    //                     'board_resource_id' => $boardResource->id ?? $validatedData['parent_id'],
    //                     'difficulty' => $upload['difficulty'],
    //                     'is_pro' => $upload['is_pro'],
    //                     'file_path' => $path,
    //                 ]);
    //             }
    //         }
    //     }

    //     return to_route('admin.board-resources.index');
    // }

    public function edit(BoardResource $boardResource): View
    {
        $data = $this->boardResourceRepository->getEditData($boardResource);

        return view('backend.resource.form', $data);
    }

    // public function edit(BoardResource $boardResource)
    // {
    //     $engineering = $boardResource->load('examBoard');
    //     $examBoard =  $engineering->examBoard;
    //     $categories = $this->categoryRepository->activeItems('is_active', 'category_name');
    //     $subCategories = SubCategory::query()->where('category_id', $examBoard->category_id)->get();
    //     $boards = Resubcategory::query()->where('category_id', $examBoard->category_id)
    //         ->where('subcategory_id', $examBoard->subcategory_id)->get();
    //     $parents = BoardResource::query()->where('resubcategory_id', $examBoard->id)
    //         ->where('is_group', 1)->get();

    //     $resourceTypes = ResourceType::options();

    //     $difficulties = DifficultyType::options();

    //     return view('backend.resource.form')->with([
    //         'resource' => $boardResource,
    //         'categories' => $categories,
    //         'subCategories' => $subCategories,
    //         'boards' => $boards,
    //         'parents' => $parents,
    //         'examBoard' => $examBoard,
    //         'resourceTypes' => $resourceTypes,
    //         'difficulties' => $difficulties,
    //     ]);
    // }

    // public function update(Request $request, BoardResource $boardResource)
    // {
    //     $validatedData = $request->validate([
    //         'resubcategory_id' => ['required', 'exists:resubcategories,id'],
    //         'name' => ['nullable', 'string', 'max:255'],
    //         'resource_type' => ['required', Rule::enum(ResourceType::class)],
    //         'parent_id' => ['nullable', 'exists:board_resources,id'],
    //         'is_group' => ['required', 'boolean'],
    //         'is_paid' => ['required', 'boolean'],
    //         'is_active' => ['required', Rule::enum(Status::class)],
    //         'is_section_title' => ['required', 'boolean'],
    //         'file_orientation' => ['nullable', 'in:1,2'],
    //         'allow_files' => ['required', 'boolean'],


    //         'uploads'              => ['nullable', 'array', 'min:1'],
    //         'uploads.*.is_pro'     => ['nullable', 'in:0,1'],
    //         'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class)],
    //         'uploads.*.pdfFile'    => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
    //     ]);

    //     $parent = BoardResource::query()->find($validatedData['parent_id'] ?? null);

    //     if ($parent && $parent->resource_type != $validatedData['resource_type']) {
    //         return back()->with('error', 'the current resource type is different from parent resource type.');
    //     }

    //     dd($parent);

    //     dd($validatedData);


    //     $boardResource->update($validatedData);

    //     // if ($boardResource->files) {
    //     //     $boardResource->files->update($validatedData);
    //     // }

    //     return to_route('admin.board-resources.index');
    // }

    public function update(AdminBoardResourceRequest $request, BoardResource $boardResource): RedirectResponse
    {
        $this->boardResourceService->update($boardResource, $request->validated());

        return to_route('admin.board-resources.index', [
            'category' => $boardResource->examBoard->category_id,
            'subcategory' => $boardResource->examBoard->subcategory_id,
            'resubcategory_id' => $boardResource->resubcategory_id,
        ])->with('success', 'Resource updated successfully.');
    }

    public function destroy(BoardResource $boardResource): RedirectResponse
    {
        $this->boardResourceService->delete($boardResource);

        return to_route('admin.board-resources.index', [
            'category' => $boardResource->examBoard->category_id,
            'subcategory' => $boardResource->examBoard->subcategory_id,
            'resubcategory_id' => $boardResource->resubcategory_id,
        ])->with('success', 'Resource deleted successfully.');
    }

    public function deleteFile(BoardResourceFile $boardResourceFile): RedirectResponse
    {
        $resourceId = $boardResourceFile->board_resource_id;

        $this->boardResourceService->deleteFile($boardResourceFile);

        return to_route('admin.board-resources.edit', $resourceId)->with('success', 'File deleted successfully.');
    }

    private function hasResourceFilters(Request $request): bool
    {
        return $request->filled(['category', 'subcategory', 'resubcategory_id',]);
    }
}
