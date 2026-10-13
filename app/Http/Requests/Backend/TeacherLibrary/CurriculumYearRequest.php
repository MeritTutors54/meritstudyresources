<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 2 — Years: used by both store and update. */
class CurriculumYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'phase_id' => [
                'required', 'integer',
                Rule::exists('curriculum_phases', 'id')->whereNull('deleted_at'),
            ],
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('curriculum_years', 'name')
                    ->ignore($this->route('year'))
                    ->whereNull('deleted_at'),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'There is already a year with this name.',
            'phase_id.required' => 'Choose a phase.',
            'phase_id.exists' => 'Choose a phase from the list.',
        ];
    }
}
