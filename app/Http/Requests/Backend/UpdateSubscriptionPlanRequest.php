<?php

namespace App\Http\Requests\Backend;

use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSubscriptionPlanRequest extends FormRequest
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
            'name' => 'required|string|max:200|unique:subscription_plans,name,' . $this->subscription_plan->id,
            'description' => 'nullable|string|max:3000',
            'user_limit' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('The ' . $attribute . ' must be zero or a positive number.');
                    }
                },
            ],
            'download_limit' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('The ' . $attribute . ' must be zero or a positive number.');
                    }
                },
            ],
            'weekly_limit' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('The ' . $attribute . ' must be zero or a positive number.');
                    }
                },
            ],
            'has_full_access' => ['nullable', 'in:0,1'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'slug' => SlugService::generateSlug($this->name ?? $this->subscriptionPlan->name)
        ]);
    }
}
