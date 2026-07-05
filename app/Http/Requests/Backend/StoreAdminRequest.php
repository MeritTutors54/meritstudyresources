<?php

namespace App\Http\Requests\Backend;

use App\Enums\Team;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'team_id' => Team::TeamAdmin->value
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:200',
            'username' => 'required|string|max:20|unique:admins,username',
            'email' => [
                'required',
                'string',
                'max:200',
                'unique:admins',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => 'required|string|min:6',
            'status' => 'required|in:0,1',
            'role' => 'required|exists:roles,name',
            'team_id' => 'required|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.max' => 'The email may not be greater than 200 characters.',
            'email.unique' => 'This email is already registered.',
            'email.regex' => 'Please enter a valid email address.',
        ];
    }

    protected function passedValidation(): void
    {

    }
}
