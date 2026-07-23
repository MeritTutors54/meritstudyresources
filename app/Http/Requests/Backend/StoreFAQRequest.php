<?php

namespace App\Http\Requests\Backend;

use App\Enums\FaqGenre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFAQRequest extends FormRequest
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
            'question' => 'required|string|max:2500',
            'answer' => 'required|string|max:2500',
            'status' => 'required|in:0,1',
            'genre' => [
                'required',
                Rule::enum(FaqGenre::class)
            ],
        ];
    }
}
