<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon
 */
class ToFrontendTimezoneMacro
{
    public function __invoke(): Closure
    {
        /**
         * Set the timezone to frontend timezone.
         */
        return function (): Carbon {
            if ($timezone = config('app.frontend_timezone')) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
