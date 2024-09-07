<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * Determine if the name of the route instance ends with `.index`;
 *
 * @mixin \Illuminate\Http\Request
 */
class IsIndexRequestMacro
{
    public function __invoke(): Closure
    {
        return function () {
            if ($this->getMethod() != 'GET') {
                return false;
            }

            return $this->routeIs('*.index');
        };
    }
}
