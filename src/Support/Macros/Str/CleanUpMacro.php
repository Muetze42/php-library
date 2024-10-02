<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Stringable;

/**
 * @mixin \Illuminate\Support\Str
 */
class CleanUpMacro
{
    public function __invoke(): Closure
    {
        /**
         * Remove unwanted characters from a string.
         */
        return function (string|Stringable|null $value): ?string {
            if (is_null($value)) {
                return null;
            }

            if ($value instanceof Stringable) {
                $value = $value->toString();
            }

            // Remove all non-printable characters
            $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u', '', $value);

            // Remove multiple whitespaces
            $value = preg_replace('/\s+/', ' ', $value);

            return trim($value);
        };
    }
}
