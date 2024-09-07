<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Support\Carbon;

/**
 * Determines if the current time is between two others.
 *
 * @mixin \Illuminate\Support\Carbon
 */
class IsTimeBetweenMacro
{
    public function __invoke(): Closure
    {
        return function (string|Carbon $startTime, string|Carbon $endTime, ?string $timezone = null): bool {
            if (is_string($startTime)) {
                $startTime = Carbon::parse($startTime);
            }
            if (is_string($endTime)) {
                $endTime = Carbon::parse($endTime);
            }

            [$now, $startTime, $endTime] = [
                Carbon::now($timezone),
                $startTime,
                $endTime,
            ];

            if ($endTime->lessThan($startTime)) {
                if ($startTime->greaterThan($now)) {
                    $startTime = $startTime->subDay();
                } else {
                    $endTime = $endTime->addDay();
                }
            }

            return $now->between($startTime, $endTime);
        };
    }
}
