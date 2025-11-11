<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSubCategoryRequest extends FormRequest
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
            'subcategory_name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'required|in:0,1',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->subcategory_name ?? '')
        ]);
    }
}
