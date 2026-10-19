<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/** Step 6 — Lessons: used by both store and update. Number and code are set by the system. */
class CurriculumLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'objective' => ['nullable', 'string', 'max:2000'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'week_number' => ['nullable', 'integer', 'min:1', 'max:60'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return ['week_number.max' => 'The week must be between 1 and 60.'];
    }
}
