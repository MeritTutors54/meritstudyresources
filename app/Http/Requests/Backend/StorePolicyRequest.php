<?php

namespace App\Http\Requests\Backend;

use App\Enums\Policy;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePolicyRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:2000',

            'status' => [
                'required',
                Rule::enum(Status::class)
            ],
            'policy' => [
                'required',
                Rule::enum(Policy::class)
            ]
        ];
    }
}
