<?php

namespace NormanHuth\Library\Macros\Carbon;

use Closure;
use Illuminate\Http\Carbon;
use Illuminate\Http\Request;

/**
 * @mixin \Illuminate\Support\Carbon
 */
class SessionTimezone
{
    /**
     * Get index number of an integer.
     */
    public function __invoke(): Closure
    {
        return function (Request $request): Carbon {
            if ($timezone = $request->session()?->get('timezone')) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
