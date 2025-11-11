<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTestimonialRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'type' => 'required|in:0,1,2,3',
            'description' => 'required|string|max:2500',
            'rating' => 'required|in:0,1,2,3,4',
        ];
    }
}
