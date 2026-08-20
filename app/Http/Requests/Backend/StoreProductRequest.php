<?php

namespace App\Http\Requests\Backend;

use App\Models\BookVariant;
use App\Services\FileService;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'sku' => 'required|string|max:200',
            'regular_price' => ['required', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'discount_price' => ['nullable', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
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
        $merges = [];
        $uploadPath = 'products';
        $sampleUploadPath = 'products/sample';

        // 1. Handle Multiple PDF Samples
        if ($this->hasFile('pdf_sample')) {
            $sampleFiles = [];
            $samples = is_array($this->file('pdf_sample'))
                ? $this->file('pdf_sample')
                : [$this->file('pdf_sample')];

            foreach ($samples as $sample) {
                if ($sample) {
                    $fileName = FileService::storeFile($sampleUploadPath, $sample);
                    $sampleFiles[] = $sampleUploadPath . '/' . $fileName;
                }
            }

            $merges['samples'] = $sampleFiles;
        }

        // 2. Handle Single Image File
        if ($this->hasFile('file')) {
            $imagesUploadedPath = FileService::storeFile($uploadPath, $this->file('file'));
            $merges['image'] = $uploadPath .'/'. $imagesUploadedPath;
        }

        // 3. Calculate Discount Percentage
        $regularPrice = (float) $this->input('regular_price', 0);
        $discountPrice = (float) $this->input('discount_price', 0);
        $discountPercentage = 0;

        if ($regularPrice > 0 && $discountPrice > 0 && $discountPrice < $regularPrice) {
            $discountPercentage = round((($regularPrice - $discountPrice) / $regularPrice) * 100, 2);
        }

        // 4. Generate Slug and Search Text safely
        $variant = BookVariant::find($this->book_variant_id);
        $variantSearchText = $variant?->search_text ?? $variant?->seach_text ?? '';

        // Filter out empty parts and join with a single space
        $searchText = implode(' ', array_filter([
            $variantSearchText,
            $this->input('title'),
            $this->input('sku'),
        ]));

        $merges = array_merge($merges, [
            'discount_percentage' => $discountPercentage,
            'slug' => SlugService::generateSlug($this->input('title', '')),
            'search_text' => trim($searchText),
        ]);

        // 5. Single Consolidated Merge
        $this->merge($merges);
    }
}
