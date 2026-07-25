<?php

namespace App\Http\Requests\Backend;

use App\Services\FileService;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|integer|exists:blog_categories,id',
            'blog_tags' => 'required|array',
            'description' => 'required|string|max:3000',
            'blog_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'details' => 'nullable|string',
            'status' => 'required|in:0,1',
            'is_feature' => 'required|in:0,1',
        ];
    }

    protected function passedValidation(): void
    {
        $imageName = '';
        $uploadPath = 'blogs';

        FileService::createDir($uploadPath);

        if ($this->hasFile('blog_image')) {
            if (!empty($this->blog->image)) {
                FileService::checkFile($this->blog->image);
            }
            $imageName = FileService::storeFile($uploadPath . '/', $this->blog_image);
        }

        $this->merge([
            'slug' => SlugService::generateSlug($this->title ?? ''),
            'author_id' => Auth::id(),
            'image' => $uploadPath . '/' . $imageName,
        ]);
    }
}
