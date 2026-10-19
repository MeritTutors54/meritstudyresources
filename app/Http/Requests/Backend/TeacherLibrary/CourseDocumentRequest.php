<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/** Step 4 — Course documents: used by both store and update (file optional on update). */
class CourseDocumentRequest extends FormRequest
{
    public const TYPES = [
        'curriculum_map'  => 'Curriculum map',
        'weekly_planning' => 'Weekly planning',
        'term_assessment' => 'Term assessment',
    ];

    public const TERMS = ['autumn' => 'Autumn', 'spring' => 'Spring', 'summer' => 'Summer'];

    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        $creating = $this->route('document') === null;

        return [
            'type' => ['required', 'in:' . implode(',', array_keys(self::TYPES))],
            'term' => ['nullable', 'required_if:type,term_assessment', 'in:' . implode(',', array_keys(self::TERMS))],
            'title' => ['required', 'string', 'max:200'],
            'file' => [$creating ? 'required' : 'nullable', 'file', 'mimes:pdf,docx,pptx,xlsx', 'max:20480'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'term.required_if' => 'Choose the term for an assessment.',
            'file.mimes' => 'Upload a PDF, Word (.docx), PowerPoint (.pptx) or Excel (.xlsx) file.',
            'file.max' => 'The file must be 20 MB or smaller.',
        ];
    }
}
