<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Str
 */
class IsDateStringMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if a given value is a date string.
         */
        return function (string $value): bool {
            return Str::isMatch(
                '/^(\d{4})-(\d{1,2})-(\d{1,2})$/',
                $value
            );
        };
    }
}
