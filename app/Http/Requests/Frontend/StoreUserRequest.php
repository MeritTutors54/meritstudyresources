<?php

namespace App\Http\Requests\Frontend;

use App\Enums\UserType;
use App\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    protected function passedValidation(): void
    {
        $team = Auth::user()->load('getCurrentTeam')->getCurrentTeam;
        $this->merge([
            'parent_id' => Auth::id(),
            'team_id' => $team->id,
            'password_in_text' => $this->password,
            'password' => Hash::make($this->password),
            'type' =>  UserType::TEACHER->value
        ]);
    }
}
