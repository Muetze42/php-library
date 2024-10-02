<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;

/**
 * @mixin \Illuminate\Support\Str
 */
class SplitNewLinesMacro
{
    public function __invoke(): Closure
    {
        /**
         * Split string by new lines.
         */
        return function (string $value): array {
            return preg_split('/\r\n|\n|\r/', $value);
        };
    }
}
