<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBookSubjectRequest extends FormRequest
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
            'name' => [
                'required', 'string', 'max:200',
                Rule::unique('book_subjects')
                    ->whereNull('deleted_at')
                    ->ignore($this->book_subject->id ?? '')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                    return $query->where('book_category_id', $this->book_category_id ?? '');
                }),
            ],
            'book_category_id' => [
                'required',
                'exists:book_categories,id',
            ],
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'This sub category already exists for the selected category.',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? '')
        ]);
    }
}
