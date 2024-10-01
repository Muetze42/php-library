<?php

namespace NormanHuth\Library\Support\CastMacros\Str;

use Closure;
use Exception;
use Illuminate\Support\Carbon;
use NormanHuth\Library\Exceptions\CastException;
use Throwable;

class CastToDateTimeMacro
{
    public function __invoke(): Closure
    {
        /**
         * Try to get the value as integer.
         */
        return function (mixed $value): int {
            if (! $value instanceof Carbon) {
                try {
                    $value = Carbon::parse($value);
                } catch (Exception | Throwable) {
                    throw new CastException('bool');
                }
            }

            return $value->tz(config('app.timezone', 'UTC'));
        };
    }
}
