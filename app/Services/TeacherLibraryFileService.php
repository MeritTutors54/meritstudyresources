<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Teacher Library files (lesson files + course documents).
 * Stored on the PRIVATE `local` disk (storage/app/teacher-library/...),
 * so a copied link cannot skip the subscription check.
 */
final class TeacherLibraryFileService
{
    public const DISK = 'local';
    public const ROOT = 'teacher-library';

    /** Files stored during this request that are not confirmed yet. */
    private static array $stored = [];

    /** @return array{file_path: string, file_ext: string, file_size: int} */
    public static function store(UploadedFile $file, string $folder, string $prefix = 'file'): array
    {
        $ext  = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $name = Str::slug($prefix) . '-' . Str::lower(Str::random(8)) . '.' . $ext;
        $dir  = self::ROOT . '/' . trim($folder, '/');

        $path = $file->storeAs($dir, $name, self::DISK);

        if ($path === false) {
            throw new \RuntimeException('The file could not be saved.');
        }

        self::$stored[] = $path;

        return [
            'file_path' => $path,
            'file_ext'  => $ext,
            'file_size' => (int) $file->getSize(),
        ];
    }

    /** The save worked: keep every file stored since the last keep/discard. */
    public static function keepStored(): void
    {
        self::$stored = [];
    }

    /** The save failed: delete every file stored since the last keep/discard. */
    public static function discardStored(): void
    {
        foreach (self::$stored as $path) {
            self::delete($path);
        }

        self::$stored = [];
    }

    public static function delete(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    /** Delete an old file once the current transaction has committed. */
    public static function deleteAfterCommit(?string $path): void
    {
        DB::afterCommit(fn () => self::delete($path));
    }

    /** Stream a file to the browser (admin preview, or a checked teacher download). */
    public static function response(string $path, ?string $downloadName = null, bool $inline = true): StreamedResponse
    {
        abort_unless(Storage::disk(self::DISK)->exists($path), 404, 'File not found.');

        $name = $downloadName
            ? Str::slug(pathinfo($downloadName, PATHINFO_FILENAME)) . '.' . pathinfo($path, PATHINFO_EXTENSION)
            : basename($path);

        return $inline
            ? Storage::disk(self::DISK)->response($path, $name)
            : Storage::disk(self::DISK)->download($path, $name);
    }

    /** Folder for a course: teacher-library/<course-slug>/... */
    public static function courseFolder(string $courseSlug, string ...$parts): string
    {
        return implode('/', array_filter([$courseSlug, ...$parts]));
    }
}