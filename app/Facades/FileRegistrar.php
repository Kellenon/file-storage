<?php

declare(strict_types=1);

namespace App\Facades;

use App\DTO\FileRegistrarDTO;
use App\Models\File;
use App\Services\File\FileRegistrar as MainFileRegistrar;
use Illuminate\Support\Facades\Facade;

/**
 * @method static File register(FileRegistrarDTO $fileRecorderDTO)
 * @see MainFileRegistrar
 */
final class FileRegistrar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainFileRegistrar::class;
    }
}
