<?php

namespace NormanHuth\Library\Macros\Number;

use Closure;

/**
 * @mixin \Illuminate\Support\Number
 */
class IndexNumber
{
    /**
     * Get index number of an integer.
     */
    public function __invoke(): Closure
    {
        return function (int $int, int $steps = 100): int {
            return (int) (floor($int / $steps)) * $steps;
        };
    }
}
