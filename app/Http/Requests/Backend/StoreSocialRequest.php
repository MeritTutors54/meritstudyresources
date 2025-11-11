<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSocialRequest extends FormRequest
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
            'type' => 'required', 'in:1,2,3,4,5,6',
            'url' => 'required', 'url', 'max:255',
            'status' => 'required', 'in:0,1',
        ];
    }
}
