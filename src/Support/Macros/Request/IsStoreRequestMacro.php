<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * Determine if the name of the route instance is a store request;
 *
 * @mixin \Illuminate\Http\Request
 */

class IsStoreRequestMacro
{
    public function __invoke(): Closure
    {
        return function () {
            return $this->getMethod() == 'POST' && $this->routeIs('*.store');
        };
    }
}
