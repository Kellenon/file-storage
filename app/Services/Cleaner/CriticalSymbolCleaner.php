<?php

declare(strict_types=1);

namespace App\Services\Cleaner;

final class CriticalSymbolCleaner
{
    public function clean(string $dirtyText): string
    {
        $regExp = '/[^a-zа-я.0-9_-]/ui';

        return preg_replace($regExp, '', trim($dirtyText));
    }
}
