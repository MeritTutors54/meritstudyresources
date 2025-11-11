<?php

namespace App\Http\Requests\Backend;

use App\Models\TopicGroup;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation(): void
    {
        $topicGroupId = TopicGroup::query()
            ->where('name', $this->topic_group ?? "")
            ->value('id');

        $this->merge([
            'topic_group_id' => $topicGroupId,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:200',
                Rule::unique('topics')->where(function ($query) {
                    return $query->where('education_level_id', $this->education_level_id)
                        ->where('topic_group_id', $this->topic_group_id)
                    ->where('subject_id', $this->subject_id);
                })
            ],
            'description' => 'nullable|string|max:2000',
            'education_level_id' => 'required|exists:education_levels,id',
            'topic_group' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'parent_id' => 'nullable|exists:topics,id',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->title)
        ]);
    }
}
