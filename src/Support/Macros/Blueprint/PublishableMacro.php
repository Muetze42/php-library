<?php

namespace NormanHuth\Library\Support\Macros\Blueprint;

use Closure;

/**
 * @mixin \Illuminate\Database\Schema\Blueprint
 */
class PublishableMacro
{
    public function __invoke(): Closure
    {
        /**
         * Add nullable published at and published until timestamp to the table.
         */
        return function ($precision = 0): void {
            $this->timestamp('published_at', $precision)->nullable();
            $this->timestamp('published_until', $precision)->nullable();
        };
    }
}
