<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;

/**
 * @mixin \Illuminate\Support\Arr
 */
class DotExceptMacro
{
    public function __invoke(): Closure
    {
        /**
         * Flatten a multi-dimensional associative array with dots and optional except keys.
         *
         * @param  iterable  $array
         * @param  string|array  $except
         * @param  string  $prepend
         * @return array
         */
        return function (iterable $array, string|array $except, string $prepend = ''): array {
            $results = [];

            $except = (array) $except;

            foreach ($array as $key => $value) {
                if (is_array($value) && ! empty($value) && ! in_array($key, $except)) {
                    $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
                } else {
                    $results[$prepend . $key] = $value;
                }
            }

            return $results;
        };
    }
}
