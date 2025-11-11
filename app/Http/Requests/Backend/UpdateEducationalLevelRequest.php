<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEducationalLevelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? "")
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:200|unique:education_levels,name,'.$this->educational_level->id,
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:0,1',
            'slug' => 'nullable|string|max:200|unique:education_levels,slug,'.$this->educational_level->id,
        ];
    }
}
