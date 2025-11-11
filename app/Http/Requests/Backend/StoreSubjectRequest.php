<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreSubjectRequest extends FormRequest
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
                Rule::unique('subjects')->where(function ($query) {
                    return $query->where('education_level_id', $this->education_level_id);
                }),
            ],
            'education_level_id' => 'required|integer|exists:education_levels,id',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'This subject already exists for the selected education level.',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->name)
        ]);
    }
}
