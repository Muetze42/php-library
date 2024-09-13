<?php

namespace NormanHuth\Library\Support\Macros\Blueprint;

use Closure;

/**
 * @mixin \Illuminate\Database\Schema\Blueprint
 */

class PublishableTzMacro
{
    public function __invoke(): Closure
    {
        /**
         * Add nullable published at and published until timestampTz to the table.
         */
        return function ($precision = 0): void {
            $this->timestampTz('published_at', $precision)->nullable();
            $this->timestampTz('published_until', $precision)->nullable();
        };
    }
}
