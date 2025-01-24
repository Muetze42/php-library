<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Str
 */
class IsBicMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if a given value is a date string.
         */
        return function (string $value): bool {
            return Str::isMatch(
                '/^[A-Za-z]{4} ?[A-Za-z]{2} ?[A-Za-z0-9]{2} ?([A-Za-z0-9]{3})?$/',
                $value
            );
        };
    }
}
