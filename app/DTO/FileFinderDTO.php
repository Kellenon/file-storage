<?php

declare(strict_types=1);

namespace App\DTO;

final class FileFinderDTO
{
    public function __construct(
        private readonly ?string $uuid = null,
        private readonly ?string $category = null,
        private readonly ?string $service = null,
        private readonly array $metadata = [],
    ) {
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
