<?php

declare(strict_types=1);

namespace App\Actions\File;

use App\DTO\FileCreatorDTO;
use App\DTO\FileRegistrarDTO;
use App\Events\NotAllFilesRegistered;
use App\Exceptions\FileNotCreatedException;
use App\Exceptions\FileNotRegisteredException;
use App\Exceptions\FilePathException;
use App\Facades\FilePathCreator;
use App\Facades\FileRegistrar;
use App\Facades\Normalizer;
use App\Models\File;
use App\Services\File\DTO\FilePathCreatorDTO;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;
use Throwable;

final class FileCreator
{
    /**
     * @param FileCreatorDTO $fileCreatorDTO
     * @return File
     * @throws FileNotCreatedException
     * @throws FileNotRegisteredException
     * @throws FilePathException
     * @throws JsonException
     * @throws Throwable
     */
    public function handle(FileCreatorDTO $fileCreatorDTO): File
    {
        $uploadedFiles = [];

        try {
            $pathToFile = sprintf(
                '%s/%s.%s',
                FilePathCreator::getCreator(
                    Normalizer::denormalize([
                        'category' => $fileCreatorDTO->getCategory(),
                        'service' => $fileCreatorDTO->getService(),
                        'metadata' => $fileCreatorDTO->getMetadata(),
                        'specialPath' => $fileCreatorDTO->getSpecialPath(),
                    ], FilePathCreatorDTO::class)
                )->create(),
                Str::random(40),
                $fileCreatorDTO->getExtension()
            );

            if (!Storage::put($pathToFile, $fileCreatorDTO->getContent())) {
                throw new FileNotCreatedException('Не удалось создать файл');
            }

            $uploadedFiles[] = $pathToFile;

            return FileRegistrar::register(
                Normalizer::denormalize([
                    'pathToFile' => $pathToFile,
                    'service' => $fileCreatorDTO->getService(),
                    'category' => $fileCreatorDTO->getCategory(),
                    'description' => $fileCreatorDTO->getDescription(),
                    'metadata' => array_merge_recursive($fileCreatorDTO->getMetadata(), [
                        'extension' => $fileCreatorDTO->getExtension(),
                    ]),
                    'availableUntil' => $fileCreatorDTO->getAvailableUntil(),
                ], FileRegistrarDTO::class)
            );
        } catch (Throwable $exception) {
            NotAllFilesRegistered::dispatch($uploadedFiles);
        }

        throw $exception;
    }
}
