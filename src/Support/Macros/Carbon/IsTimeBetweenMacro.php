<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Support\Carbon;

/**
 * Determine if the current time is between 2 specified times.
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
                    $startTime = $startTime->subDay(1);
                } else {
                    $endTime = $endTime->addDay(1);
                }
            }

            return $now->between($startTime, $endTime);
        };
    }
}
