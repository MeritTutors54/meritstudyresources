<?php

namespace App\Http\Requests\Frontend;

use App\Enums\UserType;
use App\Services\InvoiceService;
use App\Services\SlugService;
use App\Services\TokenService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreSubscribeEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'max:200',
                'regex:/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/',
                'unique:subscribe_emails,email'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.string'   => 'Email must be a string.',
            'email.max'      => 'Email may not be greater than 200 characters.',
            'email.regex'    => 'Please enter a valid email address (example: user@example.com).',
        ];
    }
}
