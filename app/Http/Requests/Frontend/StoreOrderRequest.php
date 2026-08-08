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

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard()->check();
    }

    public function rules(): array
    {
        return [
            'billing_name' => 'required|string|max:200',
            'billing_phone' => 'required|string|max:200',
            'billing_alternative_phone' => [
                'nullable',
                'string',
                'max:200',
                Rule::notIn([$this->billing_phone ?? '']),
            ],
            'billing_address' => 'required|string|max:3000',
            'remarks' => 'nullable|string|max:2000',
            'billing_city' => 'required|string|max:200',
            'billing_state' => 'required|string|max:200',
            'billing_post_code' => 'required|string|max:200',
        ];
    }

    protected function passedValidation(): void
    {
        $invoiceNumber = InvoiceService::createInvoiceNumber();
        $trackingNumber = TokenService::generate64DigitCode();

        $this->merge([
            'invoice_number' => $invoiceNumber,
            'user_id' => Auth::id(),
            'tracking_number' => $trackingNumber,
        ]);

    }
}
