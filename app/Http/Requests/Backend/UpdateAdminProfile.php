<?php

namespace App\Http\Requests\Backend;

use App\Models\Admin;
use App\Services\FileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAdminProfile extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:200',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:2000',
            'photo' => 'nullable|file|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:2048',
        ];
    }


    protected function passedValidation(): void
    {
        $uploadPath = 'admins';
        FileService::createDir($uploadPath);

        if ($this->photo) {
            $admin = Admin::query()->find(Auth::id());
            FileService::checkFile($admin->image);

            $imageName = FileService::storeFile($uploadPath . '/', $this->photo);

            $this->merge([
                'image' => $imageName,
                'name' => $this->name ?? $admin->name
            ]);
        }

    }

}
