<?php

declare(strict_types=1);

namespace App\Services\File\DTO;

use Illuminate\Support\Collection;

final class FilePathCreatorDTO
{
    public function __construct(
        private readonly Collection $metadata,
        private readonly string $service,
        private readonly string $category,
        private readonly ?string $specialPath = null,
    ) {
    }

    public function getMetadata(): Collection
    {
        return $this->metadata;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getSpecialPath(): ?string
    {
        return $this->specialPath;
    }
}
