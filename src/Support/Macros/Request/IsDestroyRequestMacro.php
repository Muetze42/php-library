<?php

namespace NormanHuth\Library\Support\Macros\Request;

use Closure;

/**
 * @mixin \Illuminate\Http\Request
 */
class IsDestroyRequestMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the name of the route instance is a destroy request.
         */
        return function (): bool {
            return $this->getMethod() === 'DELETE' && $this->routeIs('*.destroy');
        };
    }
}
