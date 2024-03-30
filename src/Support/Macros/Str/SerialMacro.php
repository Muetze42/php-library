<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Str
 */
class SerialMacro
{
    /**
     * Generate a serial number.
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU.
     */
    public function __invoke(): Closure
    {
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
