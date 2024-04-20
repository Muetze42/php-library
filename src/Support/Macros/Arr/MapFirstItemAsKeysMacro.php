<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @mixin \Illuminate\Support\Arr
 */
class MapFirstItemAsKeysMacro
{
    /**
     * Use the values of the first item in the array as the keys for next array items.
     */
    public function __invoke(): Closure
    {
        return function (
            array|Collection $array
        ): array {
            if (! $array instanceof Collection) {
                $array = collect($array);
            }

            return $array
                ->map(function (array $item) use (&$head) {
                    if (empty($head)) {
                        return $head = $item;
                    }

                    return Arr::mapWithKeys(
                        $item,
                        fn ($item, $key) => [empty($head[$key]) ? $key : $head[$key] => $item]
                    );
                })->forget(0)->toArray();
        };
    }
}
