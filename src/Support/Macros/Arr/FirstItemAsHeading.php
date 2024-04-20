<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;
use Illuminate\Support\Arr;

class FirstItemAsHeading
{
    /**
     * Use the first array items as the heading for the rest items.
     */
    public function __invoke(array $array): Closure
    {
        return collect($array)
            ->map(function (array $item) use (&$head) {
                if (empty($head)) {
                    return $head = $item;
                }

                return Arr::mapWithKeys($item, fn ($item, $key) => [empty($head[$key]) ? $key : $head[$key] => $item]);
            })->forget(0)->toArray();
    }
}
