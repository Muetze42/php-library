<?php

namespace NormanHuth\Library\Macros\Number;

use Closure;

/**
 * @mixin \Illuminate\Support\Number
 */
class CeilUpNearest
{
    /**
     * Round up to the nearest multiple of `E`.
     */
    public function __invoke(): Closure
    {
        return function (int|float $num, int $step = 5): float|int {
            if (round($step) != $step) {
                $step = round($step);
            }

            if ($step < 0) {
                $step = 1;
            }

            return ceil($num / $step) * $step;
        };
    }
}
