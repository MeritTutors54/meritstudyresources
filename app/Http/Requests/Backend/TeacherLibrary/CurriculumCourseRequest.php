<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 4 — Courses: used by both store and update. */
class CurriculumCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation(): void
    {
        // An unticked checkbox sends nothing — treat it as "no".
        $this->merge(['has_weekly_homework' => $this->boolean('has_weekly_homework')]);
    }

    public function rules(): array
    {
        return [
            'year_id' => [
                'required', 'integer',
                Rule::exists('curriculum_years', 'id')->whereNull('deleted_at'),
                // one course per year + subject (e.g. only one "Year 3 Maths")
                Rule::unique('curriculum_courses', 'year_id')
                    ->where('subject_id', (int) $this->input('subject_id'))
                    ->whereNull('deleted_at')
                    ->ignore($this->route('course')),
            ],
            'subject_id' => [
                'required', 'integer',
                Rule::exists('curriculum_subjects', 'id')->whereNull('deleted_at'),
            ],
            'title' => ['nullable', 'string', 'max:150'],
            'curriculum_label' => ['nullable', 'string', 'max:100'],
            'intro' => ['nullable', 'string', 'max:2000'],
            'planned_weeks' => ['nullable', 'integer', 'min:1', 'max:60'],
            'has_weekly_homework' => ['boolean'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'year_id.unique' => 'A course for this year and subject already exists.',
            'year_id.required' => 'Choose a year.',
            'year_id.exists' => 'Choose a year from the list.',
            'subject_id.required' => 'Choose a subject.',
            'subject_id.exists' => 'Choose a subject from the list.',
        ];
    }
}
