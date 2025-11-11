<?php

namespace App\Operations\Frontend;

use App\Models\UserDevice;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Agent\Agent;

final class ResourceActivity
{

    public static function organizeResource()
    {

    }
    public static function organizeWithGroupBy(Collection $topics): array
    {
        $grouped = [];

        foreach ($topics as $topic) {
            $topicGroupName = $topic->topicGroup?->name ?? 'Ungrouped';
            $topicGroupSlug = $topic->topicGroup?->slug ?? 'Ungrouped';

            if (!isset($grouped[$topicGroupSlug])) {
                $grouped[$topicGroupSlug] = [
                    'group' => $topicGroupName,
                    'topics_raw' => [],  // Store all topics for later tree building
                ];
            }

            $grouped[$topicGroupSlug]['topics_raw'][] = $topic;
        }

        return $grouped;
    }

    public static function constructSidebarTree(array $grouped): array
    {
        $sidebar = [];

        foreach ($grouped as $slug => $groupData) {
            $topicsTree = self::buildTopicTree($groupData['topics_raw']);
            $sidebar[] = [
                'slug' => $slug,
                'group' => $groupData['group'],
                'topics' => $topicsTree,
            ];
        }

        return $sidebar;
    }

    protected static function buildTopicTree($topics): array
    {
        $indexed = [];
        $tree = [];

        // Index topics by id
        foreach ($topics as $topic) {
            $indexed[$topic->id] = [
                'id' => $topic->id,
                'title' => $topic->title,
                'slug' => $topic->slug,
                'children' => [],
                'children_count' => 0,
                'resources' => count($topic->resources),
                'parent_id' => $topic->parent_id,
            ];
        }

        // Build tree structure
        foreach ($indexed as &$topic) {
            if ($topic['parent_id'] && isset($indexed[$topic['parent_id']])) {
                $indexed[$topic['parent_id']]['children'][] = &$topic;
                $indexed[$topic['parent_id']]['children_count']++;
            } else {
                $tree[] = &$topic;
            }
        }

        return $tree;
    }
}
