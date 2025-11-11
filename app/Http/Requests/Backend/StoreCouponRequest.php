<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCouponRequest extends FormRequest
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
            'code' => 'required|string|max:50',
            'status' => 'required|in:0,1',
            'discount_type' => 'required|in:0,1',
            'discount_value' =>  ['required', 'regex:/^\d+(\.\d{2})?$/', 'between:0,999999.99'],
            'usages_limit' => ['required', 'regex:/^[0-9]+$/'],
            'valid_from' => ['required', 'date', 'date_format:Y-m-d'],
            'valid_to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:valid_from'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'discount_value.regex' => 'Discount value must be a valid number with up to two decimal places (e.g., 10 or 10.00).',
            'usages_limit.regex' => 'Usage limit must be a valid number (e.g. 10 or 110 - no negative number)',
            'valid_to.after_or_equal' => 'The valid to date must be on or after the valid from date.',
        ];
    }
}
