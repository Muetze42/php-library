<?php

namespace NormanHuth\Library\Support\Macros\Arr;

use Closure;

/**
 * @mixin \Illuminate\Support\Arr
 */
class ToJsonPrettyMacro
{
    /**
     * Returns the JSON representation pretty and unescaped of a value.
     */
    public function __invoke(): Closure
    {
        return function (mixed $value): bool|string {
            return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        };
    }
}
