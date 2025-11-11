<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSEORequest extends FormRequest
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
            'page_title' => 'required|string',
            'meta_title' => 'nullable|string|max:3000',
            'meta_keyword' => 'nullable|string|max:3000',
            'meta_author' => 'nullable|string|max:3000',
            'meta_description' => 'nullable|string|max:3000',
            'google_verification' => 'nullable|string|max:3000',
            'bing_verification' => 'nullable|string|max:3000',
            'google_analytics' => 'nullable|string|max:3000',
            'alexa_analytics' => 'nullable|string|max:3000',
            'facebook_pixel' => 'nullable|string|max:3000'
        ];
    }
}
