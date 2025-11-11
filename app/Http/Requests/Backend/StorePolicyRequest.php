<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'key' => 'required|string',
            'value' => 'required|string',
            'status' => 'required|in:0,1'
        ];
    }
}
