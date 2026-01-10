<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePastPaperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|integer|exists:categories,id',
            'subcategory' => 'required|integer|exists:sub_categories,id',
            'resubcategory' => 'nullable|integer|exists:resubcategories,id',
            'is_paid' => 'required|boolean',
            'ques_paper' => 'nullable|file|mimes:pdf,doc,docx|max:5048',
            'ans_paper' => 'nullable|file|mimes:pdf,doc,docx|max:5048',
        ];
    }
}
