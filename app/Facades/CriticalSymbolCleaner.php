<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\Cleaner\CriticalSymbolCleaner as MainCriticalSymbolCleaner;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string clean(string $dirtyText)
 * @see MainFileRegistrar
 */
final class CriticalSymbolCleaner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MainCriticalSymbolCleaner::class;
    }
}
