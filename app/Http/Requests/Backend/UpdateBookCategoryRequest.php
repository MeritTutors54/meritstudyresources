<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBookCategoryRequest extends FormRequest
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
                'required','string', 'max:200',
                Rule::unique('book_categories')
                    ->whereNull('deleted_at')
                    ->ignore($this->book_category->id)
                    ->where(function ($query) {
                    return $query->where('name', $this->name ?? '');
                }),
            ],
            'status' => 'required|in:0,1',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? '')
        ]);
    }
}
