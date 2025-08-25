<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;

/**
 * @mixin \Illuminate\Support\Arr
 */
class WithoutRelationsMacro
{
    public function __invoke(): Closure
    {
        /**
         * Filters the given array by excluding keys that end with '_id' or '_ids'.
         */
        return static function (array $array): array {
            return static::where(
                $array,
                static fn (mixed $value, string $key) => ! str_ends_with($key, '_id') && ! str_ends_with($key, '_ids')
            );
        };
    }
}
