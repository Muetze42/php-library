<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * Determine if the name of the route instance is a create request;
 *
 * @mixin \Illuminate\Http\Request
 */
class IsCreateRequestMacro
{
    public function __invoke(): Closure
    {
        return function () {
            return $this->getMethod() == 'GET' && $this->routeIs('*.create');
        };
    }
}
