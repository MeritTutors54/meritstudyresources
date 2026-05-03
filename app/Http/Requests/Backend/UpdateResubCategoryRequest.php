<?php

namespace App\Http\Requests\Backend;

use App\Models\BookVariant;
use App\Services\FileService;
use App\Services\PDFService;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class UpdateResubCategoryRequest extends FormRequest
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
            'resubcategory_name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'required|integer|exists:sub_categories,id',
            'description' => 'nullable|string',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->resubcategory_name ?? $this->resub_category->resubcategory_name)
        ]);
    }
}
