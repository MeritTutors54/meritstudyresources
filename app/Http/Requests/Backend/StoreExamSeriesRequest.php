<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreExamSeriesRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'is_active' => 'required|in:0,1',
        ];
    }


    protected function passedValidation(): void
    {
        $this->merge([
            'name' => strtoupper($this->name)
        ]);
    }
}
