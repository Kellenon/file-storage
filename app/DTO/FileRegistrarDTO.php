<?php

declare(strict_types=1);

namespace App\DTO;

final class FileRegistrarDTO
{
    public function __construct(
        private readonly string $pathToFile,
        private readonly string $service,
        private readonly string $category,
        private readonly ?string $description = null,
        private readonly ?string $availableUntil = null,
        private readonly array $metadata = [],
    ) {
    }

    public function getPathToFile(): string
    {
        return $this->pathToFile;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getAvailableUntil(): ?string
    {
        return $this->availableUntil;
    }
}
