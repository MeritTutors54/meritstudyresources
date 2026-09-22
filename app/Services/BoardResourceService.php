<?php

namespace App\Services;

use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use App\Repositories\Interfaces\BoardResourceRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class BoardResourceService
{
    private const FILE_DISK = 'public';

    private const FILE_DIRECTORY = 'board-resource';

    public function __construct(
        protected BoardResourceRepositoryInterface $repository,
    ) {}

    public function create(array $data): BoardResource
    {
        return DB::transaction(function () use ($data) {
            $uploads = $data['uploads'] ?? [];

            unset($data['uploads']);

            $this->validateParentResourceType($data);

            $boardResource = $this->repository->create($data);

            $this->storeFiles(
                boardResource: $boardResource,
                uploads: $uploads,
            );

            return $boardResource;
        });
    }


    public function update(BoardResource $boardResource, array $data): BoardResource
    {
        return DB::transaction(function () use ($boardResource, $data) {
            $uploads = $data['uploads'] ?? [];

            unset($data['uploads']);

            $this->validateParentResourceType($data);

            $this->repository->update($data, $boardResource->id);

            $this->processUploads(boardResource: $boardResource, uploads: $uploads,);

            return $boardResource->refresh();
        });
    }

    protected function processUploads(BoardResource $boardResource, array $uploads): void
    {
        foreach ($uploads as $upload) {
            // if (!empty($upload['file_id']) && !empty($upload['pdfFile'])) {
            //     dd('jjjj');
            //     $existingFile = $boardResource->files()->whereKey($upload['file_id'])->firstOrFail();

            //     $this->replaceFile(existingFile: $existingFile, boardResource: $boardResource, upload: $upload,);
            // }

            // dd($upload);

            $this->storeFile(boardResource: $boardResource, upload: $upload,);
        }
    }

     protected function storeFile(BoardResource $boardResource, array $upload): BoardResourceFile
    {
        /** @var UploadedFile $file */
        $file = $upload['pdfFile'] ?? null;

        if (!empty($upload["file_id"])) {
            $existingFile = $boardResource->files()->whereKey($upload['file_id'])->firstOrFail();

            // If a new file is uploaded, remove the old physical file
            if ($file instanceof UploadedFile) {
                if (!empty($existingFile->file_path)) {
                    Storage::disk(self::FILE_DISK)->delete($existingFile->file_path);
                }

                $fileName = $this->generateFileName($file);

                $upload['file_path'] = $file->storeAs(self::FILE_DIRECTORY, $fileName, self::FILE_DISK);
            }

            unset($upload['pdfFile'], $upload['file_id']);

            $existingFile->update($upload);

            return $existingFile->fresh();
        }

        if ($file instanceof UploadedFile) {
            $fileName = $this->generateFileName($file);
            $upload['file_path'] = $file->storeAs(self::FILE_DIRECTORY, $fileName, self::FILE_DISK);
        }

        unset($upload['pdfFile']);

        return $boardResource->files()->create($upload);
    }


    // protected function replaceFile(BoardResourceFile $existingFile, BoardResource $boardResource, array $upload): BoardResourceFile
    // {
    //     /** @var \Illuminate\Http\UploadedFile $file */
    //     $file = $upload['pdfFile'];
    //     $newPath = $this->storeUploadedFile($file); /* * Remember the old physical path. */
    //     $oldPath = $existingFile->file_path; /* * Update the existing database record. */
    //     $existingFile->update(['file_path' => $newPath, 'difficulty' => $upload['difficulty'] ?? null, 'is_pro' => $upload['is_pro'] ?? false,]); /* * Delete the old physical file only after * the database record has been updated. */
    //     $this->deletePhysicalFile($oldPath);

    //     return $existingFile->refresh();
    // }

    protected function storeUploadedFile(\Illuminate\Http\UploadedFile $file): string
    {
        $fileName = $this->generateFileName($file);
        return $file->storeAs(self::FILE_DIRECTORY, $fileName, self::FILE_DISK);
    }

    protected function deletePhysicalFile(?string $path): void
    {
        if (!$path) {
            return;
        }
        $disk = Storage::disk(self::FILE_DISK);
        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    public function delete(BoardResource $boardResource): bool
    {
        return DB::transaction(function () use ($boardResource) {
            $this->deleteResourceTree($boardResource);
            return true;
        });
    }

    protected function deleteResourceTree(BoardResource $boardResource): void
    {
        /* * First delete all children. * * Each child can have its own children, so this * method calls itself recursively. */
        $children = $boardResource->children()->get();

        foreach ($children as $child) {
            $this->deleteResourceTree($child);
        } /* * Delete all files belonging to this resource. */

        $files = $boardResource->files()->get();

        foreach ($files as $file) {
            $this->deleteStoredFile($file);
        } /* * Finally delete the resource itself. */

        $this->repository->delete($boardResource->id);
    }

    // public function delete(BoardResource $boardResource): bool
    // {
    //     return DB::transaction(function () use ($boardResource) {
    //         $files = $boardResource->files()->get();

    //         foreach ($files as $file) {
    //             $this->deleteStoredFile($file);
    //         }

    //         return $this->repository->delete($boardResource->id);
    //     });
    // }

    public function deleteFile(BoardResourceFile $boardResourceFile): bool
    {
        return DB::transaction(function () use ($boardResourceFile) {
            $this->deleteStoredFile($boardResourceFile);

            return $boardResourceFile->delete();
        });
    }

    protected function validateParentResourceType(array $data): void
    {
        if (empty($data['parent_id'])) {
            return;
        }

        $parent = $this->repository->getParent(
            $data['parent_id']
        );

        if (
            $parent &&
            $parent->resource_type != $data['resource_type']
        ) {
            throw new RuntimeException(
                'The current resource type is different from the parent resource type.'
            );
        }
    }

    protected function storeFiles(BoardResource $boardResource, array $uploads): void
    {
        foreach ($uploads as $upload) {
            if (empty($upload['pdfFile'])) {
                continue;
            }

            $this->storeFile(
                $boardResource,
                $upload
            );
        }
    }

    protected function generateFileName(UploadedFile $file): string
    {
        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        return now()->format('YmdHis')
            . '_'
            . Str::random(8)
            . '_'
            . Str::slug($originalName)
            . '.'
            . $file->getClientOriginalExtension();
    }

    protected function deleteStoredFile(BoardResourceFile $file): void
    {
        if ($file->file_path && Storage::disk(self::FILE_DISK)->exists($file->file_path)) {
            Storage::disk(self::FILE_DISK)->delete($file->file_path);
        }
    }
}
