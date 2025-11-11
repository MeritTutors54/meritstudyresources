<?php

namespace App\Http\Requests\Backend;

use App\Services\FileService;
use App\Services\PDFService;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\countOf;

class UpdateMeritResourceRequest extends FormRequest
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
                'required',
                'string',
                'max:200',
                Rule::unique('merit_resources')
                    ->ignore($this->resource->id)
                    ->where(function ($query) {
                    return $query->where('topic_id', $this->topic_id);
                })
            ],
            'topic_id' => 'required|exists:topics,id',
            'status' => 'required|in:0,1',
            'file' => 'nullable|file|mimes:pdf|max:500',
            'description' => 'nullable|string|max:3000',
            'is_paid' => 'required|in:0,1',
        ];
    }

    protected function passedValidation(): void
    {
        $uploadPath = 'resources';
        $outputPath = 'resources/images';

        FileService::createDir($uploadPath);
        FileService::createDir($outputPath);

        if ($this->hasFile('file')) {
            FileService::checkFile($this->resource->main_pdf);

            if (count($this->resource->allPage) > 0) {
                foreach ($this->resource->allPage as $page) {
                    FileService::checkFile($page->image_path);
                    $page->delete();
                }
            }
            $imageName = FileService::storeFile($uploadPath . '/pdfs', $this->file);
            $pdfImages = PDFService::pdfToImage($uploadPath . '/pdfs/' . $imageName, $outputPath);
            $this->merge([
                'main_pdf' => $uploadPath . '/pdfs/' . $imageName,
                'pdf_images' => $pdfImages,
                'thumbnail_image' => $pdfImages[0],
            ]);
        }

        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? $this->resource->name)
        ]);
    }
}
