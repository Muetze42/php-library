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
         * Set the timezone to app timezone.
         */
        return function (): Carbon {
            if ($timezone = config('app.timezone')) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
