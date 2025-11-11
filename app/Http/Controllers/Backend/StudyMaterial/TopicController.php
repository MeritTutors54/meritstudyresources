<?php

namespace App\Http\Controllers\Backend\StudyMaterial;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\StoreTopicRequest;
use App\Http\Requests\Backend\UpdateTopicRequest;
use App\Models\Category;
use App\Models\EducationLevel;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\SubCategory;
use App\Models\TopicGroup;
use App\Operations\Backend\AdminActivity;
use App\Operations\Backend\TopicGroupActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TopicController extends Controller
{

    protected array $notification;
    protected array $log;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewStudyMaterialTopic', Auth::user());

        $topics = Topic::query()
            ->with('topicGroup', 'parent', 'educationLevel', 'subject', 'resources', 'children')
            ->get();

        return view('backend.study-material.topic.index')
            ->with([
                'topics' => $topics
            ]);
    }

    public function create(): View
    {
        $this->authorize('createStudyMaterialTopic', Auth::user());

        $statuses = Status::cases();

        $levels = EducationLevel::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $subjects = Subject::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $topicGroups = TopicGroup::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $parentTopics = Topic::query()
            ->with('educationLevel')
            ->where('status', Status::ACTIVE->value)
            ->get();

        return view('backend.study-material.topic.form')
            ->with([
                'statuses' => $statuses,
                'levels' => $levels ?? '',
                'subjects' => $subjects ?? '',
                'parentTopics' => $parentTopics ?? '',
                'topicGroups' => $topicGroups ?? ''
            ]);
    }

    public function store(StoreTopicRequest $request): RedirectResponse
    {
        $this->authorize('createStudyMaterialTopic', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Topic',
        ];

        DB::beginTransaction();

        try {
            $topicGroupID = TopicGroupActivity::getGroupID($request->topic_group);
            $request->merge(['topic_group_id' => $topicGroupID]);
            $topic = Topic::query()->create($request->all());
            AdminActivity::track($this->log, $topic);

            $this->notification['message'] = 'Course Created Successfully';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['message'] = $exception->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.topics.index')
            ->with($this->notification['alert-type'], $this->notification['message']);

    }

    public function edit(Topic $topic): View
    {
        $this->authorize('updateStudyMaterialTopic', Auth::user());

        $statuses = Status::cases();

        $levels = EducationLevel::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $subjects = Subject::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $topicGroups = TopicGroup::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $parentTopics = Topic::query()
            ->with('educationLevel')
            ->where('status', Status::ACTIVE->value)
            ->where('parent_id', null)
            ->get();

        return view('backend.study-material.topic.form')
            ->with([
                'topic' => $topic,
                'statuses' => $statuses,
                'levels' => $levels,
                'subjects' => $subjects,
                'topicGroups' => $topicGroups,
                'parentTopics' => $parentTopics,
            ]);
    }

    public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
    {
        $this->authorize('updateStudyMaterialTopic', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Topic',
            'old_data' => json_encode($topic->toArray()),
        ];

        DB::beginTransaction();

        try {
            $topicGroupID = TopicGroupActivity::getGroupID($request->topic_group);
            $request->merge(['topic_group_id' => $topicGroupID]);
            $topic->update($request->all());
            AdminActivity::track($this->log, $topic);

            $this->notification['message'] = 'Course Updated Successfully';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['message'] = $exception->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.topics.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }

    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('deleteStudyMaterialTopic', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Topic',
            'old_data' => json_encode($topic->toArray()),
        ];

        if ($topic->children()->whereNull('deleted_at')->exists()) {
            $this->notification['message'] = "Topic has child topics and cannot be deleted.";
            $this->notification['alert-type'] = 'error';

            return to_route('admin.topics.index')
                ->with($this->notification['alert-type'], $this->notification['message']);
        }

        if ($topic->resources()->whereNull('deleted_at')->exists()) {
            $this->notification['message'] = 'Topic has active resources and cannot be deleted.';
            $this->notification['alert-type'] = 'error';

            return to_route('admin.topics.index')
                ->with($this->notification['alert-type'], $this->notification['message']);
        }

        DB::beginTransaction();

        try {
            $topic->delete();
            AdminActivity::track($this->log, $topic);

            $this->notification['message'] = 'Course Deleted Successfully';
            $this->notification['alert-type'] = 'success';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['message'] = $exception->getMessage();
            $this->notification['alert-type'] = 'error';
        }

        return to_route('admin.topics.index')
            ->with($this->notification['alert-type'], $this->notification['message']);
    }
}
