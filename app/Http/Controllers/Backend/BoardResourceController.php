<?php

namespace App\Http\Controllers\Backend;

use App\Enums\DifficultyType;
use App\Enums\ResourceType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoardResourceController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected BoardResourceRepositoryInterface $boardResourceRepository,
    ) {}
    public function index(Request $request)
    {
        $data = [];

        $categories = $this->categoryRepository->activeItems('is_active', 'category_name');

        $categoryId = $request->input('category');
        $subcategoryId = $request->input('subcategory');
        $resubcategoryId = $request->input('resubcategory_id');

        $resourceType = ResourceType::options();

        if (!empty($categoryId) && !empty($subcategoryId) && !empty($resubcategoryId)) {

            $data['selectedCategory'] = $categoryId;
            $data['selectedSubCategory'] = $subcategoryId;
            $data['selectedResubcategory'] = $resubcategoryId;

            $data['subcategories'] = SubCategory::query()->where('category_id', $categoryId)->get();
            $data['resubcategories'] = Resubcategory::query()->where('category_id', $categoryId)
                ->where('subcategory_id', $subcategoryId)->get();


            // Code to run if all are empty
            $data['syllabus'] = BoardResource::with(['children.children.files', 'children.files'])
                ->where('resubcategory_id', $resubcategoryId)
                ->whereNull('parent_id')
                ->get()
                ->groupBy('resource_type')
                ->mapWithKeys(function ($item, $key) {
                    $resourceTypes = ResourceType::options();
                    $label = $resourceTypes[$key] ?? $key;

                    return [$label => $item];
                })
                ->toArray();
        }

        return view('backend.resource.index')->with([
            'categories' => $categories,
            'data' => $data,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->activeItems('is_active', 'category_name');

        $resourceTypes = ResourceType::options();

        $difficulties = DifficultyType::options();

        return view('backend.resource.form')->with([
            'categories' => $categories,
            'resourceTypes' => $resourceTypes,
            'difficulties' => $difficulties,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'resubcategory_id' => ['required', 'exists:resubcategories,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'resource_type' => ['required', Rule::enum(ResourceType::class)],
            'parent_id' => ['nullable', 'exists:board_resources,id'],
            'is_group' => ['required', 'boolean'],
            'is_paid' => ['required', 'boolean'],
            'is_active' => ['required', Rule::enum(Status::class)],
            'is_section_title' => ['required', 'boolean'],
            'file_orientation' => ['nullable', 'in:1,2'],
            'allow_files' => ['required', 'boolean'],


            'uploads'              => ['nullable', 'array', 'min:1'],
            'uploads.*.is_pro'     => ['nullable', 'in:0,1'],
            'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class)],
            'uploads.*.pdfFile'    => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $parent = BoardResource::query()->find($validatedData['parent_id'] ?? null);

        if ($parent && $parent->resource_type != $validatedData['resource_type']) {
            return back()->with('error', 'the current resource type is different from parent resource type.');
        }


        $boardResource = BoardResource::query()->create($validatedData);

        if (isset($validatedData['uploads'])) {
            foreach ($validatedData['uploads'] as $index => $upload) {
                if (isset($upload['pdfFile'])) {
                    $file = $upload['pdfFile'];

                    // Get the original file name (without extension) and extension
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();

                    // Create a unique file name using a timestamp and the original name
                    $fileName = time() . '_' . \Illuminate\Support\Str::slug($originalName) . '.' . $extension;

                    // Store the file in the 'public/pdfs' directory with the custom name
                    $path = $file->storeAs('board-resource', $fileName, 'public');

                    BoardResourceFile::query()->create([
                        'board_resource_id' => $boardResource->id ?? $validatedData['parent_id'],
                        'difficulty' => $upload['difficulty'],
                        'is_pro' => $upload['is_pro'],
                        'file_path' => $path,
                    ]);
                }
            }
        }

        return to_route('admin.board-resources.index');
    }

    public function edit(BoardResource $boardResource)
    {
        $engineering = $boardResource->load('examBoard');
        $examBoard =  $engineering->examBoard;
        $categories = $this->categoryRepository->activeItems('is_active', 'category_name');
        $subCategories = SubCategory::query()->where('category_id', $examBoard->category_id)->get();
        $boards = Resubcategory::query()->where('category_id', $examBoard->category_id)
            ->where('subcategory_id', $examBoard->subcategory_id)->get();
        $parents = BoardResource::query()->where('resubcategory_id', $examBoard->id)
            ->where('is_group', 1)->get();

        $resourceTypes = ResourceType::options();

        $difficulties = DifficultyType::options();

        return view('backend.resource.form')->with([
            'resource' => $boardResource,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'boards' => $boards,
            'parents' => $parents,
            'examBoard' => $examBoard,
            'resourceTypes' => $resourceTypes,
            'difficulties' => $difficulties,
        ]);
    }

    public function update(Request $request, BoardResource $boardResource)
    {
        $validatedData = $request->validate([
            'resubcategory_id' => ['required', 'exists:resubcategories,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'resource_type' => ['required', Rule::enum(ResourceType::class)],
            'parent_id' => ['nullable', 'exists:board_resources,id'],
            'is_group' => ['required', 'boolean'],
            'is_paid' => ['required', 'boolean'],
            'is_active' => ['required', Rule::enum(Status::class)],
            'is_section_title' => ['required', 'boolean'],
            'file_orientation' => ['nullable', 'in:1,2'],
            'allow_files' => ['required', 'boolean'],


            'uploads'              => ['nullable', 'array', 'min:1'],
            'uploads.*.is_pro'     => ['nullable', 'in:0,1'],
            'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class)],
            'uploads.*.pdfFile'    => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $parent = BoardResource::query()->find($validatedData['parent_id'] ?? null);

        if ($parent && $parent->resource_type != $validatedData['resource_type']) {
            return back()->with('error', 'the current resource type is different from parent resource type.');
        }

        dd($parent);

        dd($validatedData);


        $boardResource->update($validatedData);

        // if ($boardResource->files) {
        //     $boardResource->files->update($validatedData);
        // }

        return to_route('admin.board-resources.index');
    }

    public function destroy(BoardResource $boardResource)
    {

        dd('why this is working');
        $boardResource->delete();

        return to_route('admin.board-resources.index');
    }

    public function deleteFile(BoardResourceFile $id)
    {
        $boardResourceId = $id->board_resource_id;

        $id->delete();

        return to_route('admin.board-resources.edit', $boardResourceId)->with('success', 'File deleted successfully.');
    }
}
