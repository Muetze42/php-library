<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon;
 */
class ToUserTimezoneMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get index number of an integer.
         */
        return function (Request $request): Carbon {
            if ($timezone = $request->user()?->timezone) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
