<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * @mixin \Illuminate\Http\Request
 */
class IsCreateRequestMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the name of the route instance is a create request.
         */
        return function () {
            return $this->getMethod() == 'GET' && $this->routeIs('*.create');
        };
    }
}
