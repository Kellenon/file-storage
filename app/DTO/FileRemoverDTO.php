<?php

declare(strict_types=1);

namespace App\DTO;

final class FileRemoverDTO
{
    public function __construct(private readonly string $uuid)
    {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
