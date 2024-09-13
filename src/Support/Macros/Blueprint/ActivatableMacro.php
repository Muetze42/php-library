<?php

namespace NormanHuth\Library\Support\Macros\Blueprint;

use Closure;

/**
 * @mixin \Illuminate\Database\Schema\Blueprint
 */
class ActivatableMacro
{
    public function __invoke(): Closure
    {
        /**
         * Add nullable activated at and activated until timestamp columns to the table.
         */
        return function ($precision = 0): void {
            $this->timestamp('activated_at', $precision)->nullable();
            $this->timestamp('activated_until', $precision)->nullable();
        };
    }
}
