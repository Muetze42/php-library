<?php

namespace NormanHuth\Library\Support\CastMacros\Str;

use Closure;
use NormanHuth\Library\Exceptions\CastException;

class CastToFloatMacro
{
    public function __invoke(): Closure
    {
        /**
         * Try to get the value as integer.
         */
        return function (mixed $value): int {
            if (is_float($value)) {
                return $value;
            }

            if (is_string($value) && is_numeric($value)) {
                return (float) $value;
            }

            throw new CastException('bool');
        };
    }
}
