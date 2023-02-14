<?php

declare(strict_types=1);

namespace App\Services\File\Path\Factory;

use App\Services\File\DTO\FilePathCreatorDTO;
use App\Services\File\Path\DefaultFilePathCreator;
use App\Services\File\Path\FilePathCreatorInterface;

final class FilePathCreatorFactory
{
    /**
     * @param FilePathCreatorDTO $filePathCreatorDTO
     * @return FilePathCreatorInterface
     */
    public function getCreator(FilePathCreatorDTO $filePathCreatorDTO): FilePathCreatorInterface
    {
        foreach ($this->getCreators($filePathCreatorDTO) as $filePathCreator) {
            if ($filePathCreator->canCreate()) {
                return $filePathCreator;
            }
        }

        return new DefaultFilePathCreator($filePathCreatorDTO);
    }

    /**
     * @return FilePathCreatorInterface[]
     */
    public function getCreators(FilePathCreatorDTO $filePathCreatorDTO): array
    {
        return [];
    }
}
