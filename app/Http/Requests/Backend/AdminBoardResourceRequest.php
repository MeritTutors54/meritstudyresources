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
        return [
            'resubcategory_id' => ['required', 'exists:resubcategories,id',],
            'name' => ['nullable', 'string', 'max:255',],
            'resource_type' => ['required', Rule::enum(ResourceType::class),],
            'parent_id' => ['nullable', 'exists:board_resources,id',],
            'is_group' => ['required', 'boolean',],
            'is_paid' => ['required', 'boolean',],
            'is_active' => ['required', Rule::enum(Status::class),],
            'is_section_title' => ['nullable', 'boolean',],
            'file_orientation' => ['nullable', 'in:1,2',],
            'allow_files' => ['required', 'boolean',],
            'uploads' => ['nullable', 'array',],
            'uploads.*.file_id' => ['nullable', 'exists:board_resource_files,id'],
            'uploads.*.is_pro' => ['nullable', 'boolean',],
            'uploads.*.difficulty' => ['nullable', Rule::enum(DifficultyType::class),],
            'uploads.*.pdfFile' => ['nullable', 'file', 'mimes:pdf', 'max:10240',],
        ];
    }
}
