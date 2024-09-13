<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * @mixin \Illuminate\Http\Request
 */
class IsIndexRequestMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the name of the route instance is an index request.
         */
        return function () {
            return $this->getMethod() == 'GET' && $this->routeIs('*.index');
        };
    }
}
