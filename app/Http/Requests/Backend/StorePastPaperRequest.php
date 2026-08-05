<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePastPaperRequest extends FormRequest
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
            'exam_series' => 'required|integer|exists:past_paper_years,id',
            'category' => 'required|integer|exists:categories,id',
            'subcategory' => 'required|integer|exists:sub_categories,id',
            'resubcategory' => 'required|integer|exists:resubcategories,id',
            'is_paid' => 'required|boolean',
            'ques_paper' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'ans_paper' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'is_active' => 'required|integer|in:0,1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
}
