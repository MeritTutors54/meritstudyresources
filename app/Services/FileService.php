<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class FileService
{
    public static function checkFile(?string $file): void
    {
        if ($file !== null) {
            if (Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }
    public static function storeFile($path, UploadedFile $file): string
    {
        $image = time() . '-' . $file->getClientOriginalName();
        $imageName = $image;
        $file->storeAs($path, $imageName, 'public');

        return $imageName;
    }

    public static function createDir(string $path): void
    {
        $dirPath = storage_path('app/public/') . $path;

        if (!File::exists($dirPath)) {
            File::makeDirectory($dirPath, 0755, true);

            chmod($dirPath, 0755);
        }
    }

}
