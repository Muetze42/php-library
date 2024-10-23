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
                '/^[A-Z]{4}[-]{0,1}[A-Z]{2}[-]{0,1}[A-Z0-9]{2}[-]{0,1}[0-9]{3}$/',
                $value
            );
        };
    }
}
