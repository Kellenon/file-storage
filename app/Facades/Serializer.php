<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Serializer\Serializer as MainSerializer;

/**
 * @method static string serialize($data, string $format, array $context = [])
 * @method static mixed denormalize($data, string $type, string $format, array $context = [])
 * @see MainSerializer
 */
final class Serializer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainSerializer::class;
    }
}
