<?php

namespace App\Http\Controllers\Backend;

use App\Enums\DifficultyType;
use App\Enums\ResourceType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoardResourceController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected BoardResourceRepositoryInterface $boardResourceRepository,
    )
    {}
    public function index()
    {

//        $nodes = BoardResource::query()->where('parent_id', null)
//            ->where('is_group', 1)->get();

        $syllabus = BoardResource::with(['children.children.files', 'children.files'])
            ->whereNull('parent_id')
            ->get()
            ?->toArray();

//        dd($syllabus);

        $categories = $this->categoryRepository->activeItems('is_active', 'category_name');
//        $categories = BoardResource::query()->where('is_group', 1)
//            ->get();
//
//        dd($categories);

        $resourceTypes = ResourceType::options();

        return view('backend.resource.index')->with([
            'categories' => $categories,
            'resourceTypes' => $resourceTypes,
            'nodes' => $syllabus
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->activeItems('is_active', 'category_name');

        $resourceTypes = ResourceType::options();

//        $parents = $this->boardResourceRepository->getParents();
        $parents = BoardResource::query()->where('is_group', 1)->get();

        $difficulties = DifficultyType::options();

        return view('backend.resource.form')->with([
            'categories' => $categories,
            'resourceTypes' => $resourceTypes,
            'parents' => $parents,
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

            'type' => ['required', 'in:1,2'],
            'difficulty' => ['nullable', Rule::enum(DifficultyType::class)],
            'is_pro' => ['required', 'boolean'],
            'pdfFile' => ['nullable', 'mimes:pdf', 'mimetypes:application/pdf', 'max:2048'],
        ]);

        if (!empty($validatedData['name'])) {
            $boardResource = $this->boardResourceRepository->create($validatedData);
        }


        if ($request->hasFile('pdfFile')) {
            $file = $request->file('pdfFile');

            // Get the original file name (without extension) and extension
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Create a unique file name using a timestamp and the original name
            $fileName = time() . '_' . \Illuminate\Support\Str::slug($originalName) . '.' . $extension;

            // Store the file in the 'public/pdfs' directory with the custom name
            $path = $file->storeAs('board-resource', $fileName, 'public');

            // Add the path to your validated data array for saving to the database
            $validatedData['pdf_path'] = $path;

            $result = BoardResourceFile::query()->create([
                'type' => $validatedData['type'],
                'board_resource_id' => $boardResource->id ?? $validatedData['parent_id'],
                'difficulty' => $validatedData['difficulty'],
                'is_pro' => $validatedData['is_paid'],
                'file_path' => $validatedData['pdf_path'],
            ]);
        }

        return to_route('admin.board-resources.index');
    }
}
