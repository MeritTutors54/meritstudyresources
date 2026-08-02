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

class UpdateProductRequest extends FormRequest
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
                    ->ignore($this->product->id)
                    ->whereNull('deleted_at')
                    ->where(function ($query) {
                        return $query->where('book_variant_id', $this->book_variant_id ?? '');
                    }),
            ],
            'book_variant_id' => 'required|integer|exists:book_variants,id',
            'description' => 'nullable|string|max:3000',
            'regular_price' => ['required', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'discount_price' => ['nullable', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'status' => 'required|in:0,1',
            'year_group_id' => 'required|integer|exists:year_groups,id',
            'sku' => 'required|string|max:100',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pdf_sample' => ['nullable', 'array', 'min:1'],
            'pdf_sample.*' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'regular_price.regex' => 'The price must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
            'discount_price.regex' => 'The price must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
            'name.unique' => 'Product is already exists for the selected variant.',
            'file.required' => 'Product image is required.',
            'pdf_sample.required' => 'Please upload at least one sample PDF.',
        ];
    }

    protected function passedValidation(): void
    {
        $uploadPath = 'products';
        $sampleUploadPath = 'products/sample';

        // if input has PDF sample
        if ($this->hasFile('pdf_sample')) {
            if ($this->product->getSampleImages()->count() > 0) {
                foreach ($this->product->getSampleImages as $prevImage) {
                    FileService::checkFile($prevImage->path);
                }
            }
            $sample_files = [];
            foreach ($this->pdf_sample as $sample) {
                $imageName = FileService::storeFile($sampleUploadPath . '/', $sample ?? '');
                $sample_files[] = $sampleUploadPath . '/' . $imageName;
            }

            $this->merge([
                'samples' => $sample_files
            ]);
        }

        // If input has file then store the file
        if ($this->hasFile('file')) {
            if (!empty($this->product->image)) {
                FileService::checkFile($this->product->image);
            }
            $imageName = FileService::storeFile($uploadPath . '/', $this->file ?? '');

            $this->merge([
                'image' => $uploadPath . '/' . $imageName,
            ]);
        }

        // Discount Percentage
        $regularPrice = (float)($this->regular_price ?? 0);
        $discountPrice = (float)($this->discount_price ?? 0);

        $discountPercentage = null;

        // Calculate percentage only if regular price is valid and discount price is provided
        if ($regularPrice > 0 && $this->filled('discount_price')) {
            // Formula: ((Regular Price - Discount Price) / Regular Price) * 100
            $calculated = (($regularPrice - $discountPrice) / $regularPrice) * 100;

            // Round to 2 decimal places (or use round($calculated) for whole numbers)
            $discountPercentage = max(0, round($calculated, 2));
        }

        // Generating Slug
        $this->merge([
            'slug' => SlugService::generateSlug($this->title ?? ''),
            'discount_percentage' => $discountPercentage,
        ]);
    }
}
