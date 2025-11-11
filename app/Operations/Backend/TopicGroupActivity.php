<?php

namespace App\Operations\Backend;

use App\Enums\Status;
use App\Models\TopicGroup;
use App\Services\SlugService;
use Illuminate\Support\Facades\DB;

final class TopicGroupActivity
{
    public static function getGroupID(string $topicGroupName)
    {
        $result = TopicGroup::query()
            ->where('name', $topicGroupName)
            ->where('status', Status::ACTIVE->value)
            ->first();

        if (!$result) {
            $result = TopicGroup::query()->create([
                'name' => $topicGroupName,
                'status' => Status::ACTIVE->value,
                'slug' => SlugService::generateSlug($topicGroupName)
            ]);
        }

        return $result->id;
    }
}
