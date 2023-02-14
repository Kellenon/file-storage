<?php

declare(strict_types=1);

namespace App\Facades;

use ArrayObject;
use Illuminate\Support\Facades\Facade;
use App\Services\Serializer\Normalizer as MainNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

/**
 * @method static string|array|bool|ArrayObject|int|float|null normalize($data, string $format = null, array $context = [])
 * @method static mixed denormalize($data, string $type, string $format = null, array $context = [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])
 * @see MainNormalizer
 */
final class Normalizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainNormalizer::class;
    }
}
