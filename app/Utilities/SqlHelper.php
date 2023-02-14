<?php

declare(strict_types=1);

namespace App\Utilities;

use Illuminate\Database\Eloquent\Builder;

final class SqlHelper
{
    public static function getRawSql(Builder $builder): string
    {
        return vsprintf(str_replace('?', '"%s"', $builder->toSql()), $builder->getBindings());
    }
}
