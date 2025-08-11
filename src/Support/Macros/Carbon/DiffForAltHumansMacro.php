<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Carbon\CarbonInterface;
use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon
 */
class DiffForAltHumansMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get the difference in a human-readable format in the current locale from a current instance to another instance given (or now if null given).
         */
        return function (
            array|Carbon|DateTimeInterface|null|string $other = null,
            array|int $syntax = CarbonInterface::DIFF_RELATIVE_TO_NOW,
            bool $short = false,
            int $parts = 1,
            ?int $options = null
        ) {
            return $this->diffForHumans($other, $syntax, $short, $parts, $options);
        };
    }
}
