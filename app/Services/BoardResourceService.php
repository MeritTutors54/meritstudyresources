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

            // $this->repository->update(
            //     $boardResource,
            //     $data
            // );

            $this->storeFiles(
                boardResource: $boardResource,
                uploads: $uploads,
            );

            return $boardResource->refresh();
        });
    }

    public function delete(BoardResource $boardResource): bool
    {
        return DB::transaction(function () use ($boardResource) {
            $files = $boardResource->files()->get();

            foreach ($files as $file) {
                $this->deleteStoredFile($file);
            }

            return $this->repository->delete($boardResource);
        });
    }

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

    protected function storeFile(BoardResource $boardResource, array $upload): BoardResourceFile
    {
        /** @var UploadedFile $file */
        $file = $upload['pdfFile'];

        $fileName = $this->generateFileName($file);

        $path = $file->storeAs(
            self::FILE_DIRECTORY,
            $fileName,
            self::FILE_DISK
        );

        return $boardResource->files()->create([
            'difficulty' => $upload['difficulty'] ?? null,
            'is_pro' => $upload['is_pro'] ?? false,
            'file_path' => $path,
        ]);
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
