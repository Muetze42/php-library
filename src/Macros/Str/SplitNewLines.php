<?php

namespace NormanHuth\Library\Macros\Str;

use Closure;

/**
 * @mixin \Illuminate\Support\Str
 */
class SplitNewLines
{
    /**
     * Split string by new lines.
     */
    public function __invoke(): Closure
    {
        return function (string $string): array {
            return preg_split('/\r\n|\n|\r/', $string);
        };
    }
}
