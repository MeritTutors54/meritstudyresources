<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 3 — File types: used by both store and update. */
class LessonResourceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('lesson_resource_types', 'name')
                    ->ignore($this->route('resource_type')),
            ],
            'icon' => ['nullable', 'string', 'max:60', 'regex:/^[a-z0-9-]+$/'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'There is already a file type with this name.',
            'icon.regex' => 'Use a Bootstrap icon name such as calculator or easel (lowercase letters, numbers and dashes).',
        ];
    }
}
