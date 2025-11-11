<?php

namespace App\Http\Requests\Backend;

use App\Models\Topic;
use App\Services\FileService;
use App\Services\PDFService;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreMeritResourceRequest extends FormRequest
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
                Rule::unique('merit_resources')->where(function ($query) {
                    return $query->where('topic_id', $this->topic_id);
                })
            ],
            'topic_id' => 'required|exists:topics,id',
            'status' => 'required|in:0,1',
            'file' => 'required|required|file|mimes:pdf|max:500',
            'description' => 'nullable|string|max:3000',
            'is_paid' => 'required|in:0,1',
        ];
    }

    protected function passedValidation(): void
    {
        $search_text = "";

        $topic = Topic::query()
            ->with('subject', 'topicGroup', 'educationLevel', 'parent')
            ->where('id', $this->topic_id)->first();

        $search_text .= SlugService::generateSlug($topic->educationLevel->name);
        $search_text .= '-' . SlugService::generateSlug($topic->subject->name);
        $search_text .= '-' . SlugService::generateSlug($topic->topicGroup->name);
        if(!empty($topic->parent)) {
            $search_text .= '-' . SlugService::generateSlug($topic->parent->title);
        }
        $search_text .= '-' . SlugService::generateSlug($topic->title);
        $search_text .= '-' . SlugService::generateSlug($this->name);

        $uploadPath = 'resources';
        $outputPath = 'resources/images';

        FileService::createDir($uploadPath);
        FileService::createDir($outputPath);

        if ($this->hasFile('file')) {
            $imageName = FileService::storeFile($uploadPath . '/pdfs', $this->file);

            $pdfImages = PDFService::pdfToImage($uploadPath . '/pdfs/' . $imageName, $outputPath);

            $this->merge([
                'main_pdf' => $uploadPath . '/pdfs/' . $imageName,
                'pdf_images' => $pdfImages,
                'thumbnail_image' => $pdfImages[0],
            ]);
        }

        $this->merge([
            'slug' => SlugService::generateSlug($this->name),
            'search_text' => $search_text,
        ]);
    }
}
