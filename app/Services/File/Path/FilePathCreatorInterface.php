<?php

declare(strict_types=1);

namespace App\Services\File\Path;

interface FilePathCreatorInterface
{
    public function create(): string;

    public function canCreate(): bool;
}
