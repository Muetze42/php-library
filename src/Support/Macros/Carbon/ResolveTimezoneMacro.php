<?php

namespace NormanHuth\Library\Support\Macros\Carbon;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Support\Carbon
 */
class ResolveTimezoneMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get index number of an integer.
         */
        return function (?Request $request = null): Carbon {
            if (! $request) {
                $request = app(Request::class);
            }

            if ($timezone = $request->session()?->get('timezone')) {
                return $this->tz($timezone);
            }
            if ($timezone = $request->user()?->timezone) {
                return $this->tz($timezone);
            }
            if ($timezone = config('app.timezone')) {
                return $this->tz($timezone);
            }

            return $this;
        };
    }
}
