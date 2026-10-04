<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\ResourceType;
use App\Enums\Status;
use App\Enums\DifficultyType;
use Illuminate\Validation\Rule;

class AdminBoardResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        $uploadCount = count($this->input('uploads', []));
        $isStraight = $this->input('file_orientation') == 1;
        $hasParent = $this->filled('parent_id');

        return [
            'resubcategory_id' => ['required', 'exists:resubcategories,id',],
            'name' => ['nullable', 'string', 'max:255',],
            'resource_type' => ['required', Rule::enum(ResourceType::class),],
            'parent_id' => ['nullable', 'exists:board_resources,id',],
            'is_group' => ['required', 'boolean',
                Rule::when(!$isStraight && $uploadCount > 1, ['accepted']),
            ],
            'is_paid' => ['required', 'boolean',],
            'is_active' => ['required', Rule::enum(Status::class),],
            'is_section_title' => ['nullable', 'boolean',],
            'file_orientation' => ['nullable', 'in:1,2',],
            'allow_files' => ['required', 'boolean',],
            'uploads' => ['nullable', 'array', Rule::when(!$hasParent, ['prohibited']), Rule::when($isStraight, ['max:1']),],
            'uploads.*.file_id' => ['nullable', 'exists:board_resource_files,id'],
            'uploads.*.is_pro' => ['nullable', 'boolean',],
            'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class),],
            'uploads.*.pdfFile' => ['nullable', 'file', 'mimes:pdf', 'max:10240',],
        ];
    }

    public function messages(): array
    {
        return [
            'uploads.prohibited' => 'Files can only be uploaded when a parent is selected.',
            'is_group.accepted' => 'Group must be enabled when uploading more than one file.',
            'uploads.max' => 'Only one file is allowed for straight orientation.',
        ];
    }
}
