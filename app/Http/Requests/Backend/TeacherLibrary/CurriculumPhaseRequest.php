<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 1 — Phases: used by both store and update. */
class CurriculumPhaseRequest extends FormRequest
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
                Rule::unique('curriculum_phases', 'name')
                    ->ignore($this->route('phase'))
                    ->whereNull('deleted_at'),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'There is already a phase with this name.',
        ];
    }
}
