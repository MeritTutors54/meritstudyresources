<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SyncPermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
            'permissions' => "required|array|min:1",
            'permissions.*' => "required|string|distinct|min:1",
        ];
    }

    protected function passedValidation(): void
    {
//        if (count($this->input('permissions')) > 0) {
//            $this->merge([
//                'permissions' => array_keys($this->input('permissions'))
//            ]);
//        }
    }
}
