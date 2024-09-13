<?php

namespace NormanHuth\Library\Support\Macros\Blueprint;

use Closure;

/**
 * @mixin \Illuminate\Database\Schema\Blueprint
 */
class ActivatableTzMacro
{
    public function __invoke(): Closure
    {
        /**
         * Add nullable activated at and activated until timestampTz to the table.
         */
        return function ($precision = 0): void {
            $this->timestampTz('activated_at', $precision)->nullable();
            $this->timestampTz('activated_until', $precision)->nullable();
        };
    }
}
