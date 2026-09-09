<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\SEOPage;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\Seo;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicGroup;
use App\Operations\Frontend\ResourceActivity;
use App\Services\SlugService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\MeritResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public array $topics;

    public function __construct()
    {

    }

    public function search(Request $request): View
    {
        if (Auth::check()) {
            $this->authorize('viewResourcesSection', Auth::user());
        }

        $trackForChild = false;

        $keyword = SlugService::generateSlug($request->q);

        $resources = MeritResource::query()
            ->with(['topic.topicGroup', 'topic.educationLevel', 'topic.subject', 'topic.parent', 'topic.children'])
            ->where('search_text', 'like', "%{$keyword}%")
            ->get();

        $tree = [];

        if (!empty($resources)) {
            foreach ($resources as $resource) {
                $topic = null;
                $parentTopic = null;

                $stgTopic = $resource->topic->parent;
                if ($stgTopic) {
                    $topic = $stgTopic;
                    if ($stgTopic->parent) {
                        $parentTopic = $stgTopic->parent;
                    }
                } else {
                    $topic = $resource->topic;
                    $parentTopic = $topic->parent;
                }

                $educationLevel = $topic->educationLevel;
                $subject = $topic->subject;
                $topicGroup = $topic->topicGroup;
                $subTopic = $topic->children;

                $levelKey = $educationLevel?->slug ?? 'unknown';
                $subjectKey = $subject?->slug ?? 'unknown';
                $groupKey = $topicGroup?->slug ?? 'no-group';
                $parentKey = $parentTopic?->slug ?? null;
                $topicKey = $topic->slug ?? 'unknown';


                // Set meta for Education Level
                $tree[$levelKey]['_meta'] = [
                    'name' => $educationLevel?->name ?? 'Unknown',
                    'slug' => $educationLevel?->slug ?? 'unknown',
                ];

                // Set meta for Subject
                $tree[$levelKey]['subjects'][$subjectKey]['_meta'] = [
                    'name' => $subject?->name ?? 'Unknown',
                    'slug' => $subject?->slug ?? 'unknown',
                ];

                // Set meta for Topic Group
                $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['_meta'] = [
                    'name' => $topicGroup?->name ?? 'General',
                    'slug' => $topicGroup?->slug ?? 'no-group',
                ];

                // Set meta for Topic parent if parent is present
                if ($parentTopic) {
                    $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['parents'][$parentKey]['_meta'] = [
                        'name' => $parentTopic?->title ?? 'Unknown',
                        'slug' => $parentTopic?->slug ?? 'unknown',
                    ];

                    $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['parents'][$parentKey]['topics'][$topicKey]['_meta'] = [
                        'name' => $topic->title,
                        'slug' => $topic->slug,
                    ];

                    if (count($subTopic) > 0) {
                        $trackForChild = true;
                        foreach ($subTopic as $sub) {
                            $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['parents'][$parentKey]['topics'][$topicKey]['subTopic'][$sub->slug] = [
                                'name' => $sub->title,
                                'slug' => $sub->slug,
                            ];

                            if ($sub->slug == $resource->topic->slug) {
                                $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['parents'][$parentKey]['topics'][$topicKey]['subTopic'][$sub->slug]['resource'][] = $resource;
                            }
                        }
                    }

//                    $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['parents'][$parentKey]['topics'][$topicKey]['resources'][] = $resource;
                } else {
                    // Topic has no parent
                    $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['topics'][$topicKey]['_meta'] = [
                        'name' => $topic->title,
                        'slug' => $topic->slug,
                    ];

                    $tree[$levelKey]['subjects'][$subjectKey]['groups'][$groupKey]['topics'][$topicKey]['resources'][] = $resource;
                }

            }
        }

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::RESOURCES->value)
            ->first();


        return view('frontend.resource.search')
            ->with(['resources' => $resources ?? '',
                'tree' => $tree,
                'trackForChild' => $trackForChild,
                'q' => $keyword,
                'defaultSEO' => $defaultSEO,
            ]);
    }

    public function educationalLevelResource(
        $educationLevelSlug = null
    ): View
    {
        if (Auth::check()) {
            $this->authorize('viewResourcesSection', Auth::user());
        }

        $educationLevels = EducationLevel::query()
            ->with('allSubjects');

        if (!empty($educationLevelSlug)) {
            $educationLevels->where('slug', $educationLevelSlug);
        }

        $educationLevels = $educationLevels
            ->where('status', Status::ACTIVE->value)
            ->get();

        $latestResources = MeritResource::query()
            ->with('topic.educationLevel', 'allPage');

        if (!empty($educationLevelSlug)) {
            $latestResources->whereHas('topic.educationLevel', function ($query) use ($educationLevelSlug) {
                $query->where('slug', $educationLevelSlug);
            });
        }

        $latestResources = $latestResources
            ->latest() // Order by created_at DESC
            ->take(10)
            ->get();

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::RESOURCES->value)
            ->first();

        return view('frontend.resource.index')
            ->with([
                'mainView' => true,
                'educationLevels' => $educationLevels ?? "",
                'allResources' => $latestResources ?? '',
                'defaultSEO' => $defaultSEO,
            ]);
    }

    public function topicResource(
        $educationLevelSlug,
        $subjectSlug,
        $groupSlug = null,
        $topicSlug = null,
        $subTopicSlug = null): View
    {
        if (Auth::check()) {
            $this->authorize('viewResourcesSection', Auth::user());
        }

        $educationModel = EducationLevel::findActiveBySlug($educationLevelSlug);
        $subjectModel = Subject::findActiveBySlug($subjectSlug);
        $groupModel = TopicGroup::findActiveBySlug($groupSlug);
        $topicModel = Topic::findActiveBySlug($topicSlug);
        $subTopicModel = Topic::findActiveBySlug($subTopicSlug);

        $topics = Topic::with([
            'parent',
            'children.children.resources.allPage', // For deep nesting (up to grandchild)
            'parent.parent',     // To access grandparent
            'topicGroup',
            'subject',
            'educationLevel',
            'resources.allPage',
        ])
            ->whereHas('subject', function ($query) use ($subjectSlug) {
                $query->where('slug', $subjectSlug);
            })
            ->whereHas('educationLevel', function ($query) use ($educationLevelSlug) {
                $query->where('slug', $educationLevelSlug);
            });

        if (!empty($groupSlug)) {
            $topics->whereHas('topicGroup', function ($query) use ($groupSlug) {
                $query->where('slug', $groupSlug);
            });
        }

        $topics = $topics->get();

        // group by topic group
        $grouped = ResourceActivity::organizeWithGroupBy($topics);
        // build sidebar tree with all available topics
        $sidebar = ResourceActivity::constructSidebarTree($grouped);


        // organize resource
        $allResources = new Collection();

        foreach ($topics as $topic) {
            $allResources = $allResources->merge($topic->resources);
            foreach ($topic->children as $child) {
                $allResources = $allResources->merge($child->resources);
                foreach ($child->children as $grandchild) {
                    $allResources = $allResources->merge($grandchild->resources);
                }
            }
        }

        $bag = [];

        $allResources = $allResources->unique('id')
            ->sortByDesc('created_at')
            ->values()
            ->load('topic');

        // Case 1: subTopicModel has children → group by matching child slug
        if (!empty($topicModel) && !empty($subTopicModel) && $subTopicModel->children->isNotEmpty()) {
            foreach ($subTopicModel->children as $child) {
                $bag[$child->title]['title'] = $child->title;
                $bag[$child->title]['slug'] = $child->slug;
                $bag[$child->title]['des'] = $child->description;
                $bag[$child->title]['resource'] = $allResources->filter(function ($resource) use ($child) {
                    return $resource->topic && $resource->topic->slug === $child->slug;
                })->values(); // reset keys
            }
        }

        if (!empty($bag)) {
            $bin['misc'] = 'active';
            $bin['topics'] = $bag;
            $allResources = $bin;
        }
        // Case 1: ends

        // Case 2: filter by subTopicModel
        if (!empty($subTopicModel)) {
            if (empty($bag)) {
                $allResources = $allResources->filter(function ($resource) use ($subTopicModel) {
                    return $resource->topic && $resource->topic->slug === $subTopicModel->slug;
                })->values();
            }
        }
        // Case 2: ends

        // Case 3: filter by topicModel
        elseif (!empty($topicModel)) {
            $allResources = $allResources->filter(function ($resource) use ($topicModel) {
                return $resource->topic && $resource->topic->slug === $topicModel->slug;
            })->values();
        }

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::RESOURCES->value)
            ->first();

        return view('frontend.resource.index')
            ->with([
                'sidebar' => $sidebar,
                'levelModel' => $educationModel ?? '',
                'subjectModel' => $subjectModel ?? '',
                'groupModel' => $groupModel ?? '',
                'topicModel' => $topicModel ?? '',
                'subTopicModel' => $subTopicModel ?? '',
                'allResources' => $allResources ?? '',
                'defaultSEO' => $defaultSEO,
            ]);
    }


    public function resourceDetails($resource, $resourceSlug): View
    {
        if (Auth::check()) {
            $this->authorize('viewResourcesSection', Auth::user());
        }

        $resourceModel = MeritResource::query()
            ->with([
                'topic.parent.parent.educationLevel',
                'topic.parent.parent.subject',
                'topic.parent.parent.topicGroup',
                'allPage',
            ])
            ->where('slug', $resourceSlug)
            ->where('id', $resource)
            ->first();

        $levelModel = null;
        $subjectModel = null;
        $groupModel = null;
        $topicModel = null;
        $subTopicModel = null;
        $extraModel = null;

        if ($resourceModel->topic) {
            if ($resourceModel->topic->parent) {
                if ($resourceModel->topic->parent->parent) {
                    $levelModel = $resourceModel->topic->parent->parent->educationLevel;
                    $subjectModel = $resourceModel->topic->parent->parent->subject;
                    $groupModel = $resourceModel->topic->parent->parent->topicGroup;
                    $topicModel = $resourceModel->topic->parent->parent;
                    $subTopicModel = $resourceModel->topic->parent;
                    $extraModel = $resourceModel->topic;
                } else {
                    $levelModel = $resourceModel->topic->parent->educationLevel;
                    $subjectModel = $resourceModel->topic->parent->subject;
                    $groupModel = $resourceModel->topic->parent->topicGroup;
                    $topicModel = $resourceModel->topic->parent;
                    $subTopicModel = $resourceModel->topic;
                }
            } else {
                $levelModel = $resourceModel->topic->educationLevel;
                $subjectModel = $resourceModel->topic->subject;
                $groupModel = $resourceModel->topic->topicGroup;
                $topicModel = $resourceModel->topic;
            }
        }


        $topics = Topic::with([
            'parent',
            'children.children.resources.allPage', // For deep nesting (up to grandchild)
            'parent.parent',     // To access grandparent
            'topicGroup',
            'subject',
            'educationLevel',
            'resources.allPage',
        ])
            ->whereHas('subject', function ($query) use ($subjectModel) {
                $query->where('slug', $subjectModel->slug);
            })
            ->whereHas('educationLevel', function ($query) use ($levelModel) {
                $query->where('slug', $levelModel->slug);
            });

        if (!empty($groupModel)) {
            $topics->whereHas('topicGroup', function ($query) use ($groupModel) {
                $query->where('slug', $groupModel->slug);
            });
        }

        $topics = $topics->get();


        // group by topic group
        $grouped = ResourceActivity::organizeWithGroupBy($topics);
        // build sidebar tree with all available topics
        $sidebar = ResourceActivity::constructSidebarTree($grouped);

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::RESOURCES->value)
            ->first();

        $buildInKeywords = $resourceModel->topic->title . ', '
        . $resourceModel->topic->educationLevel->name . ', '
        . $resourceModel->topic->subject->name . ', '
        . $resourceModel->topic->topicGroup->title;


        $buildInDescription  = $resourceModel->topic->description . ', '
            . $resourceModel->topic->educationLevel->description . ', '
            . $resourceModel->topic->subject->description . ', '
            . $resourceModel->topic->topicGroup->description;

        $seo['meta_keywords'] = !empty($defaultSEO) ? $defaultSEO->meta_keyword . ', ' . $buildInKeywords : $buildInKeywords;
        $seo['meta_author'] = $defaultSEO->meta_author ?? '';
        $seo['meta_description'] = !empty($defaultSEO) ? $defaultSEO->meta_description . ', ' . $buildInDescription : $buildInDescription;

        return view('frontend.resource.details')
            ->with([
                'sidebar' => $sidebar,
                'levelModel' => $levelModel ?? '',
                'subjectModel' => $subjectModel ?? '',
                'groupModel' => $groupModel ?? '',
                'topicModel' => $topicModel ?? '',
                'subTopicModel' => $subTopicModel ?? '',
                'resource' => $resourceModel,
                'extraModel' => $extraModel ?? '',
                'relatedResources' => "",
                'seo' => $seo,
            ]);
    }


    public
    function getSideMenuItems($educationSlug, $subjectSlug): Collection
    {
        $topic = Topic::query()
            ->with('educationLevel', 'subject', 'topicGroup', 'resources.allPage');

        if (!empty($educationSlug)) {
            $topic->whereHas('educationLevel', function ($query) use ($educationSlug) {
                $query->where('slug', $educationSlug);
            });
        }

        if (!empty($subjectSlug)) {
            $topic->whereHas('subject', function ($query) use ($subjectSlug) {
                $query->where('slug', $subjectSlug);
            });
        }


        return $topic->where('status', Status::ACTIVE->value)
            ->whereDoesntHave('parent')
            ->get()
            ->groupBy(function ($topic) {
                return optional($topic->topicGroup)->name ?? 'No Group';
            });
    }

    public
    function getResourceItem(
        $educationLevelSlug,
        $subjectSlug,
        $groupSlug,
        $topicSlug,
        $subTopicSlug,
        $view,
    ): Collection
    {

        $resources = MeritResource::query()
            ->with('topic.educationLevel', 'topic.subject', 'allPage');

        if (!empty($educationLevelSlug)) {
            $resources->whereHas('topic.educationLevel', function ($query) use ($educationLevelSlug) {
                $query->where('slug', $educationLevelSlug);
            });
        }

        if (!empty($subjectSlug)) {
            $resources->whereHas('topic.subject', function ($query) use ($subjectSlug) {
                $query->where('slug', $subjectSlug);
            });
        }

        if (!empty($groupSlug)) {
            $resources->whereHas('topic.topicGroup', function ($query) use ($groupSlug) {
                return $query->where('slug', $groupSlug);
            });
        }

        if (!empty($topicSlug)) {
            if (empty($subTopicSlug)) {
                // if this has only topic, no sub topic, not children of sub topic
                if ($view === 'base') {
                    return $resources->whereHas('topic', function ($query) use ($topicSlug) {
                        $query->where('slug', $topicSlug);
                    })->latest()->take(20)->get();
                }

                // if this has topic and children of topic
                return $resources->whereHas('topic.parent', function ($query) use ($topicSlug) {
                    $query->where('slug', $topicSlug);
                })->latest()->take(20)->get()->groupBy(function ($resource) {
                    return $resource->topic->title;
                });
            }

            // if this has only topic, sub topic and children of sub topic
            return $resources->whereHas('topic.parent', function ($query) use ($subTopicSlug) {
                $query->where('slug', $subTopicSlug);
            })->latest()->take(20)->get()->groupBy(function ($resource) {
                return $resource->topic->title;
            });
        }


        //it might have no use
        return $resources->latest() // Order by created_at DESC
        ->take(20)
            ->get();
    }
}
