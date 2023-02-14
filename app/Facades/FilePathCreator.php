<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\File\DTO\FilePathCreatorDTO;
use App\Services\File\Path\Factory\FilePathCreatorFactory;
use App\Services\File\Path\FilePathCreatorInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FilePathCreatorInterface getCreator(FilePathCreatorDTO $filePathCreatorDTO)
 * @see MainFileRegistrar
 */
final class FilePathCreator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FilePathCreatorFactory::class;
    }
}
