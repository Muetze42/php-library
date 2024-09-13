<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Str
 */
class SerialMacro
{
    public function __invoke(): Closure
    {
        /**
         * Generate a serial number.
         *
         * @example YCY8N-DWCII-W63JY-A71PA-FTUMU.
         */
        return function (
            bool $toUpper = true,
            int $parts = 5,
            int $partLength = 5,
            string $separator = '-'
        ): string {
            $keyParts = [];
            for ($i = 1; $i <= $parts; $i++) {
                $keyParts[] = Str::random($partLength);
            }

            $key = implode($separator, $keyParts);

            return $toUpper ? Str::upper($key) : $key;
        };
    }
}
