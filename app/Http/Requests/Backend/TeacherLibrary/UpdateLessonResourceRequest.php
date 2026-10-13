<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 7 — edit one lesson file (the file itself is optional: only to replace it). */
class UpdateLessonResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_paid' => $this->boolean('is_paid'),
            'is_pro'  => $this->boolean('is_pro'),
        ]);
    }

    public function rules(): array
    {
        return [
            'resource_type_id' => ['required', 'integer', Rule::exists('lesson_resource_types', 'id')],
            'title' => ['required', 'string', 'max:200'],
            'file' => ['nullable', 'file', 'mimes:' . StoreLessonResourceRequest::MIMES, 'max:' . StoreLessonResourceRequest::MAX_KB],
            'is_paid' => ['boolean'],
            'is_pro' => ['boolean'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'Upload a PDF, PowerPoint (.pptx), Word (.docx) or Excel (.xlsx) file.',
            'file.max' => 'The file must be 50 MB or smaller.',
        ];
    }
}
