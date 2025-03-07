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
        return function (string|Stringable|null $value, string $additionalTrimCharacters = ''): ?string {
            if (is_null($value)) {
                return null;
            }

            if ($value instanceof Stringable) {
                $value = $value->toString();
            }

            $value = trim(static::trim($value), $additionalTrimCharacters);

            // Remove all non-printable characters
            $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u', '', $value);

            return static::trim(trim($value, $additionalTrimCharacters));
        };
    }
}
