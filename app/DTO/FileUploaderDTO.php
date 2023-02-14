<?php

declare(strict_types=1);

namespace App\DTO;

final class FileUploaderDTO
{
    public function __construct(
        private readonly array $files,
        private readonly string $category,
        private readonly string $service,
        private readonly array $metadata = [],
        private readonly ?string $description = null,
        private readonly ?string $availableUntil = null,
        private readonly ?string $specialPath = null,
    ) {
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getService(): string
    {
        return $this->service;
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

    public function getSpecialPath(): ?string
    {
        return $this->specialPath;
    }
}
