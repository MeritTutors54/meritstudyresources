<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/** Step 5 — Units: used by both store and update. The unit number is set by the system. */
class CurriculumUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:0,1'],
        ];
    }
}
