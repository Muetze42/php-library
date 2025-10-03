<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * @mixin \Illuminate\Http\Request
 */
class IsShowRequestMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the name of the route instance is a show request.
         */
        return function (): bool {
            return $this->getMethod() === 'GET' && $this->routeIs('*.show');
        };
    }
}
