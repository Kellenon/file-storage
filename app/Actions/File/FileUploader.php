<?php

declare(strict_types=1);

namespace App\Actions\File;

use App\DTO\FileRegistrarDTO;
use App\DTO\FileUploaderDTO;
use App\Events\FilesRegistered;
use App\Events\NotAllFilesRegistered;
use App\Exceptions\FileNotCreatedException;
use App\Exceptions\FileNotRegisteredException;
use App\Exceptions\FilePathException;
use App\Facades\FilePathCreator;
use App\Facades\FileRegistrar;
use App\Facades\Normalizer;
use App\Models\File;
use App\Services\File\DTO\FilePathCreatorDTO;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use JsonException;
use Throwable;

final class FileUploader
{
    /**
     * @param FileUploaderDTO $fileUploaderDTO
     * @return File[]
     * @throws FileNotRegisteredException
     * @throws FilePathException
     * @throws JsonException
     * @throws Throwable
     */
    public function handle(FileUploaderDTO $fileUploaderDTO): array
    {
        $registeredFiles = [];
        $uploadedFiles = [];

        DB::beginTransaction();

        try {
            foreach ($fileUploaderDTO->getFiles() as $downloadableFile) {
                /** @var UploadedFile $downloadableFile */
                $pathToFile = $downloadableFile->store(
                    FilePathCreator::getCreator(
                        Normalizer::denormalize([
                            'category' => $fileUploaderDTO->getCategory(),
                            'service' => $fileUploaderDTO->getService(),
                            'metadata' => $fileUploaderDTO->getMetadata(),
                            'specialPath' => $fileUploaderDTO->getSpecialPath(),
                        ], FilePathCreatorDTO::class)
                    )->create()
                );

                if (empty($pathToFile)) {
                    throw new FileNotCreatedException('Не удалось сохранить файл');
                }

                $uploadedFiles[] = $pathToFile;
                $registeredFiles[] = FileRegistrar::register(
                    Normalizer::denormalize([
                        'pathToFile' => $pathToFile,
                        'service' => $fileUploaderDTO->getService(),
                        'category' => $fileUploaderDTO->getCategory(),
                        'description' => $fileUploaderDTO->getDescription(),
                        'metadata' => array_merge_recursive($fileUploaderDTO->getMetadata(), [
                            'originalName' => pathinfo($downloadableFile->getClientOriginalName(), PATHINFO_FILENAME),
                            'extension' => $downloadableFile->extension(),
                        ]),
                        'availableUntil' => $fileUploaderDTO->getAvailableUntil(),
                    ], FileRegistrarDTO::class)
                );
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();
            NotAllFilesRegistered::dispatch($uploadedFiles);
            throw $exception;
        }

        FilesRegistered::dispatch($registeredFiles);

        return $registeredFiles;
    }
}
