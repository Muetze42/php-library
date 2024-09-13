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
        return function (string|Stringable|null $string): ?string {
            if (is_null($string)) {
                return null;
            }

            if ($string instanceof Stringable) {
                $string = $string->toString();
            }

            // Remove all non-printable characters
            $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u', '', $string);

            // Remove multiple whitespaces
            $string = preg_replace('/\s+/', ' ', $string);

            return trim($string);
        };
    }
}
