<?php

declare(strict_types=1);

namespace App\Services\Serializer\Normalizer;

use ArrayObject;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CollectionNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return $data instanceof Collection ? $data : collect($data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Collection::class;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array|float|int|bool|ArrayObject|string|null
    {
        if (!$object instanceof Collection) {
            throw new InvalidArgumentException(sprintf('The object must implement the "%s"', Collection::class));
        }

        return $object->toArray();
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Collection;
    }
}
