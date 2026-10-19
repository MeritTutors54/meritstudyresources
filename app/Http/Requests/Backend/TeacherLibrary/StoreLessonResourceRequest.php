<?php

namespace App\Http\Requests\Backend\TeacherLibrary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/** Step 7 — upload one or more lesson files in one go: files[0][...], files[1][...] */
class StoreLessonResourceRequest extends FormRequest
{
    public const MIMES = 'pdf,pptx,docx,xlsx';
    public const MAX_KB = 51200;   // 50 MB — check php.ini upload_max_filesize / post_max_size allow it

    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation(): void
    {
        // Unticked checkboxes send nothing: make every row's flags explicit booleans.
        $files = collect($this->input('files', []))->map(fn ($row) => array_merge(is_array($row) ? $row : [], [
            'is_paid' => filter_var($row['is_paid'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'is_pro'  => filter_var($row['is_pro'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]))->all();

        $this->merge(['files' => $files]);
    }

    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*.resource_type_id' => ['required', 'integer', Rule::exists('lesson_resource_types', 'id')->where('status', 1)],
            'files.*.title' => ['required', 'string', 'max:200'],
            'files.*.file' => ['required', 'file', 'mimes:' . self::MIMES, 'max:' . self::MAX_KB],
            'files.*.is_paid' => ['boolean'],
            'files.*.is_pro' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Add at least one file.',
            'files.max' => 'Upload up to 10 files at once.',
            'files.*.resource_type_id.required' => 'Row :position: choose a file type.',
            'files.*.resource_type_id.exists' => 'Row :position: choose a file type from the list.',
            'files.*.title.required' => 'Row :position: enter a title.',
            'files.*.file.required' => 'Row :position: choose a file.',
            'files.*.file.mimes' => 'Row :position: upload a PDF, PowerPoint (.pptx), Word (.docx) or Excel (.xlsx) file.',
            'files.*.file.max' => 'Row :position: the file must be 50 MB or smaller.',
            'files.*.file.uploaded' => 'Row :position: the upload failed — the file may be bigger than the server allows.',
        ];
    }
}
