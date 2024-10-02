<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Str
 */
class IsAtomMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if a given value is a ATOM datetime string.
         */
        return function (string $value): bool {
            return Str::isMatch(
                '/\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2]\d|3[0-1])T[0-2]\d:[0-5]\d:[0-5]\d[+-][0-2]\d:[0-5]\d/',
                $value
            );
        };
    }
}
