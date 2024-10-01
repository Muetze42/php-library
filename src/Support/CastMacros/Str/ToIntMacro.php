<?php

namespace NormanHuth\Library\Support\CastMacros\Str;

use Closure;
use NormanHuth\Library\Exceptions\CastException;

class ToIntMacro
{
    public function __invoke(): Closure
    {
        /**
         * Try to get the value as integer.
         */
        return function (mixed $value): int {
            if (is_int($value)) {
                return $value;
            }

            if (is_string($value) && is_numeric($value)) {
                return (int) $value;
            }

            throw new CastException('bool');
        };
    }
}
