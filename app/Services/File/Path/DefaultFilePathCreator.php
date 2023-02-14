<?php

declare(strict_types=1);

namespace App\Services\File\Path;

use App\Facades\CriticalSymbolCleaner;
use App\Services\File\DTO\FilePathCreatorDTO;
use Carbon\CarbonImmutable;

final class DefaultFilePathCreator implements FilePathCreatorInterface
{
    public function __construct(private readonly FilePathCreatorDTO $filePathCreatorDTO)
    {
    }

    public function create(): string
    {
        $now = new CarbonImmutable('now');

        return sprintf(
            'services/%s/%s/%s/%s/%s',
            CriticalSymbolCleaner::clean($this->filePathCreatorDTO->getService()),
            implode('/', explode('.', CriticalSymbolCleaner::clean($this->filePathCreatorDTO->getCategory()))),
            $now->format('Y'),
            $now->format('m'),
            $now->format('d')
        );
    }

    public function canCreate(): bool
    {
        return true;
    }
}
