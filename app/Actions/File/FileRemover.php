<?php

declare(strict_types=1);

namespace App\Actions\File;

use App\DTO\FileRemoverDTO;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class FileRemover
{
    /**
     * @param FileRemoverDTO $fileRemoverDTO
     * @return bool
     * @throws Throwable
     */
    public function handle(FileRemoverDTO $fileRemoverDTO): bool
    {
        $file = File::query()->where('uuid', $fileRemoverDTO->getUuid())->limit(1)->first();

        if (null === $file) {
            return true;
        }

        if (!Storage::exists($file->path)) {
            return filter_var($file->deleteOrFail(), FILTER_VALIDATE_BOOLEAN);
        }

        if (Storage::delete($file->path)) {
            return filter_var($file->deleteOrFail(), FILTER_VALIDATE_BOOLEAN);
        }

        return false;
    }
}
