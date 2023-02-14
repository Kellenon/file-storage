<?php

declare(strict_types=1);

namespace App\Actions\File;

use App\DTO\FileFinderDTO;
use App\Exceptions\UuidInvalidException;
use App\Facades\CriticalSymbolCleaner;
use App\Facades\Normalizer;
use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

final class FileFinder
{
    /**
     * @param FileFinderDTO $fileFinderDTO
     * @return File|File[]
     * @throws UuidInvalidException
     * @throws ModelNotFoundException
     * @throws QueryException
     */
    public function handle(FileFinderDTO $fileFinderDTO): File|array
    {
        if (empty(array_filter(Normalizer::normalize($fileFinderDTO)))) {
            return [];
        }

        if (null !== $fileFinderDTO->getUuid()) {
            if (!Uuid::isValid($fileFinderDTO->getUuid())) {
                throw new UuidInvalidException(sprintf('UUID [%s] не является валидным', $fileFinderDTO->getUuid()));
            }

            return File::query()->findOrFail($fileFinderDTO->getUuid());
        }

        $fileQuery = File::query()->whereNotNull('metadata');

        if (null !== $fileFinderDTO->getCategory()) {
            $fileQuery->where('category', CriticalSymbolCleaner::clean($fileFinderDTO->getCategory()));
        }

        if (null !== $fileFinderDTO->getService()) {
            $fileQuery->where('service', CriticalSymbolCleaner::clean($fileFinderDTO->getService()));
        }

        foreach (Arr::dot($fileFinderDTO->getMetadata()) as $metadataKey => $metadataValue) {
            $fileQuery->where(sprintf('metadata->%s', implode('->', explode('.', CriticalSymbolCleaner::clean($metadataKey)))), $metadataValue);
        }

        return $fileQuery->orderBy('created_at', 'desc')->limit(500)->get()->all();
    }
}
