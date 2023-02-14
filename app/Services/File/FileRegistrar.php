<?php

declare(strict_types=1);

namespace App\Services\File;

use App\DTO\FileRegistrarDTO;
use App\Exceptions\FileNotRegisteredException;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JsonException;

final class FileRegistrar
{
    /**
     * @param FileRegistrarDTO $fileRegistrarDTO
     * @return File
     * @throws FileNotRegisteredException
     * @throws JsonException
     */
    public function register(FileRegistrarDTO $fileRegistrarDTO): File
    {
        $file = new File();
        $file->uploader_id = Auth::user()->id ?? null;
        $file->url = Storage::url($fileRegistrarDTO->getPathToFile());
        $file->service = $fileRegistrarDTO->getService();
        $file->description = null !== $fileRegistrarDTO->getDescription() ? trim($fileRegistrarDTO->getDescription()) : null;
        $file->path = $fileRegistrarDTO->getPathToFile();
        $file->available_until = $fileRegistrarDTO->getAvailableUntil();
        $file->category = $fileRegistrarDTO->getCategory();
        $file->metadata = json_encode($fileRegistrarDTO->getMetadata(), JSON_THROW_ON_ERROR);
        $file->disk = config('filesystems.default');

        if (!$file->save()) {
            throw new FileNotRegisteredException('Не удалось сохранить файл в базе данных');
        }

        return $file;
    }
}
