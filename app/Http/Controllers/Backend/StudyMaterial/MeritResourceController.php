<?php

namespace App\Http\Controllers\Backend\StudyMaterial;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreMeritResourceRequest;
use App\Http\Requests\Backend\UpdateMeritResourceRequest;
use App\Models\Topic;
use App\Models\MeritResource;
use App\Models\SubCategory;
use App\Operations\Backend\AdminActivity;
use App\Operations\Backend\PDFActivity;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class MeritResourceController extends Controller
{
    protected array $log;
    protected array $notification;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewStudyMaterialUpload', Auth::user());

        $resources = MeritResource::query()
            ->with('topic', 'allPage')
            ->get();

        return view('backend.study-material.index')
            ->with([
                'resources' => $resources,
            ]);
    }

    public function create(): View
    {
        $this->authorize('createStudyMaterialUpload', Auth::user());

        $statuses = Status::cases();

        $topics = Topic::query()
            ->where('status', Status::ACTIVE->value)
            ->whereDoesntHave('children')
            ->get();

        return view('backend.study-material.form')
            ->with([
                'statuses' => $statuses,
                'topics' => $topics,
            ]);
    }

    public function store(StoreMeritResourceRequest $request): RedirectResponse
    {
        $this->authorize('createStudyMaterialUpload', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\MeritResource',
        ];

        DB::beginTransaction();
        try {
            $resource = MeritResource::query()->create($request->all());
            AdminActivity::track($this->log, $resource);

            PDFActivity::insertPDFImagesIntoDB($resource->id, $request->pdf_images, $request->topic_id);

            $this->notification['message'] = 'Merit Resource was created.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            FileService::checkFile($request->main_pdf);

            if (isset($request->pdf_images) && is_array($request->pdf_images) && count($request->pdf_images) > 0) {
                foreach ($request->pdf_images as $image) {
                    FileService::checkFile($image);
                }
            }

            $this->notification['message'] = $th->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.resources.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function edit(MeritResource $resource): View
    {
        $this->authorize('updateStudyMaterialUpload', Auth::user());

        $statuses = Status::cases();

        $topics = Topic::query()
            ->where('status', Status::ACTIVE->value)
            ->whereDoesntHave('children')
            ->get();

        return view('backend.study-material.form')
            ->with([
                'statuses' => $statuses,
                'topics' => $topics,
                'resource' => $resource,
            ]);
    }

    public function update(UpdateMeritResourceRequest $request, MeritResource $resource): RedirectResponse
    {
        $this->authorize('updateStudyMaterialUpload', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\MeritResource',
            'old_data' => json_encode($resource->toArray()),
        ];

        DB::beginTransaction();

        try {
            $resource->update($request->all());
            AdminActivity::track($this->log, $resource);

            PDFActivity::insertPDFImagesIntoDB($resource->id, $request->pdf_images, $request->topic_id);

            $this->notification['message'] = 'Merit Resource was updated.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            FileService::checkFile($request->main_pdf);

            if (isset($request->pdf_images) && is_array($request->pdf_images) && count($request->pdf_images) > 0) {
                foreach ($request->pdf_images as $image) {
                    FileService::checkFile($image);
                }
            }

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.resources.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(MeritResource $resource): RedirectResponse
    {
        $this->authorize('deleteStudyMaterialUpload', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\MeritResource',
            'old_data' => json_encode($resource->toArray()),
        ];

        DB::beginTransaction();

        try {
            $resource->delete();
            AdminActivity::track($this->log, $resource);

            $this->notification['message'] = 'Merit Resource was deleted.';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->notification['message'] = $e->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.resources.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
