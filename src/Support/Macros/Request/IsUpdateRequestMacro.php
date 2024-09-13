<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * @mixin \Illuminate\Http\Request
 */
class IsUpdateRequestMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the name of the route instance is an update request.
         *
         * @mixin \Illuminate\Http\Request
         */
        return function () {
            return in_array($this->getMethod(), ['PUT', 'PATCH']) && $this->routeIs('*.update');
        };
    }
}
