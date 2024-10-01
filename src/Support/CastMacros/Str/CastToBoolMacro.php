<?php

namespace NormanHuth\Library\Support\CastMacros\Str;

use Closure;
use Illuminate\Support\Str;
use NormanHuth\Library\Exceptions\CastException;

/**
 * @mixin \Illuminate\Support\Str
 */
class CastToBoolMacro
{
    public function __invoke(): Closure
    {
        /**
         * Try to get the value as boolean.
         */
        return function (mixed $value): bool {
            if (is_bool($value)) {
                return $value;
            }

            if (is_string($value)) {
                return Str::trim($value) == 'true';
            }

            throw new CastException('bool');
        };
    }
}
