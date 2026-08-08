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

class StoreProductRequest extends FormRequest
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
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('products')
                    ->whereNull('deleted_at')
                    ->where('book_variant_id', $this->book_variant_id)
                    ->where('year_group_id', $this->year_group_id),
            ],
            'book_variant_id' => 'required|exists:book_variants,id',
            'year_group_id' => 'required|exists:year_groups,id',
            'description' => 'nullable|string|max:3000',
            'regular_price' => ['required', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'discount_price' => ['nullable', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'discount_percentage' => ['nullable', 'numeric', 'between:0,100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'status' => 'required|in:0,1',
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'pdf_sample' => ['required', 'array', 'min:1'],
            'pdf_sample.*' => 'required|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'A product with this title already exists for the selected variant, category, subject, and year group.',
            'regular_price.regex' => 'The price must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
            'discount_price.regex' => 'The price must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
            'discount_percentage.regex' => 'The discount percentage must have up to two decimal places (e.g., 15 or 15.50).',
            'discount_percentage.between' => 'The discount percentage must be between 0 and 100.',
            'file.required' => 'Product image is required.',
            'pdf_sample.required' => 'Please upload at least one sample PDF.',
        ];
    }

    protected function passedValidation(): void
    {
//        dd('ssss');
        $uploadPath = 'products';
        $sampleUploadPath = 'products/sample';
//
        if($this->hasFile('pdf_sample')) {
            $sample_files =  [];
            foreach ($this->pdf_sample as $sample) {
                $imageName = FileService::storeFile($sampleUploadPath . '/', $sample ?? '');
                $sample_files[] = $sampleUploadPath . '/' . $imageName;
            }

            $this->merge([
                'samples' => $sample_files
            ]);
        }
//
        if ($this->hasFile('file')) {
            $imageName = FileService::storeFile($uploadPath . '/', $this->file ?? '');

            $this->merge([
                'image' => $uploadPath . '/' . $imageName,
            ]);
        }
//
        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? '')
        ]);

    }
}
