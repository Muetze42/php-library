<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;

/**
 * @mixin \Illuminate\Support\Arr
 */
class KeyValueInsertToPositionMacro
{
    /**
     * Add an array key value pair to specific position into an existing key value array.
     */
    public function __invoke(): Closure
    {
        return function (
            array $array,
            string $key,
            mixed $value,
            int $position,
            bool $insertAfter = true
        ): array {
            $results = [];
            $items = array_keys($array);

            foreach ($items as $index => $item) {
                if ($index == $position && ! $insertAfter) {
                    $results[$key] = $value;
                }

                $results[$item] = $array[$item];

                if ($index == $position && $insertAfter) {
                    $results[$key] = $value;
                }
            }

            return $results;
        };
    }
}
