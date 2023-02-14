<?php

declare(strict_types=1);

namespace App\DTO;

final class FileCreatorDTO
{
    public function __construct(
        private readonly string $content,
        private readonly string $extension,
        private readonly string $category,
        private readonly string $service,
        private readonly array $metadata = [],
        private readonly ?string $availableUntil = null,
        private readonly ?string $description = null,
        private readonly ?string $specialPath = null,
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getAvailableUntil(): ?string
    {
        return $this->availableUntil;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSpecialPath(): ?string
    {
        return $this->specialPath;
    }
}
