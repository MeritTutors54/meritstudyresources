<?php

namespace App\Http\Requests\Backend;

use App\Models\BookCategory;
use App\Models\BookSubject;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBookVariantRequest extends FormRequest
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
                Rule::unique('book_variants')
                    ->whereNull('deleted_at')
                    ->ignore($this->book_variant->id ?? '')
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                    return $query->where('book_category_id', $this->book_category_id ?? '')
                        ->where('book_subject_id', $this->book_subject_id ?? '');
                }),
            ],
            'book_subject_id' => [
                'required',
                'exists:book_subjects,id',
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
        $slug = SlugService::generateSlug($this->name ?? '');
        $category = BookCategory::query()->find($this->book_category_id ?? '');
        $subject = BookSubject::query()->find($this->book_subject_id ?? '');

        $this->merge([
            'slug' => $slug,
            'search_text' => $category->slug . '-'. $subject->slug .'-'. $slug,
        ]);
    }
}
