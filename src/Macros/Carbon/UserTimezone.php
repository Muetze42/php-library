<?php

namespace NormanHuth\Library\Macros\Carbon;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon;
 */
class UserTimezone
{
    /**
     * Get index number of an integer.
     */
    public function __invoke(): Closure
    {
        return function (Request $request): Carbon {
            if ($timezone = $request->user()?->timezone) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
