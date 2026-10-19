<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 3 — Subjects: used by both store and update. */
class CurriculumSubjectRequest extends FormRequest
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
                Rule::unique('curriculum_subjects', 'name')
                    ->ignore($this->route('subject'))
                    ->whereNull('deleted_at'),
            ],
            'icon' => ['nullable', 'string', 'max:60', 'regex:/^[a-z0-9-]+$/'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'There is already a subject with this name.',
            'icon.regex' => 'Use a Bootstrap icon name such as calculator or easel (lowercase letters, numbers and dashes).',
        ];
    }
}
