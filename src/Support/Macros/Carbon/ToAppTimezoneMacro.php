<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon
 */
class ToAppTimezoneMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get index number of an integer.
         */
        return function (): Carbon {
            if ($timezone = config('app.public_timezone')) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
