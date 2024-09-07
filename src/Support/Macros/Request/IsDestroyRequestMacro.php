<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * Determine if the name of the route instance is a destroy request;
 *
 * @mixin \Illuminate\Http\Request
 */
class IsDestroyRequestMacro
{
    public function __invoke(): Closure
    {
        return function () {
            return $this->getMethod() == 'DELETE' && $this->routeIs('*.destroy');
        };
    }
}
