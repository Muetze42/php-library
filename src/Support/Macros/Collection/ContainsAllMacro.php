<?php

namespace NormanHuth\Library\Support\Macros\Collection;

use Closure;
use Illuminate\Support\Collection;

/**
 * @mixin \Illuminate\Support\Collection
 *
 * This class is derived from the code of the spatie/laravel-collection-macros package
 *
 * @see https://github.com/spatie/laravel-collection-macros
 */
class ContainsAllMacro
{
    public function __invoke(): Closure
    {
        /**
         * Determine if the collection contains any of the given items.
         */
        return function (array|Collection $items): bool {
            if (! $items instanceof Collection) {
                $items = collect($items);
            }

            return $this->intersect($items)->count() == $items->count();
        };
    }
}
