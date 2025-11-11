<?php

namespace App\Http\Requests\Backend;

use App\Services\FileService;
use App\Services\PDFService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSiteSettingsRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'email' => [
                'nullable',
                'email',
                'regex:/^[\w\.\-]+@[\w\-]+\.[\w\-\.]+$/',
            ],
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:2000',
            'fax' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:5100',
            'fab_logo' => 'nullable|file|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex'    => 'Please enter a valid email address.',
        ];
    }

    protected function passedValidation(): void
    {

        $uploadPath = 'site';
        FileService::createDir($uploadPath);

        if ($this->has('logo')) {
            if(!empty($this->siteSettings->site_logo)){
                FileService::checkFile($this->siteSettings->site_logo);
            };

            $imageName = FileService::storeFile($uploadPath . '/', $this->logo);

            $this->merge([
                'site_logo' => $uploadPath . '/' . $imageName,
            ]);
        }

        if ($this->has('fab_logo')) {
            if(!empty($this->siteSettings->site_favicon)){
                FileService::checkFile($this->siteSettings->site_favicon);
            };

            $fileName = FileService::storeFile($uploadPath . '/', $this->fab_logo);

            $this->merge([
                'site_favicon' => $uploadPath . '/' . $fileName,
            ]);
        }

    }

}
