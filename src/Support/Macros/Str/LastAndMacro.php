<?php

namespace NormanHuth\Library\Support\Macros\Str;

use Closure;
use Illuminate\Support\Arr;

/**
 * @mixin \Illuminate\Support\Str
 *
 * @deprecated Use \Illuminate\Support\Arr::join instead
 */
class LastAndMacro
{
    /**
     * Replace the last comma in a list with `and`.
     */
    public function __invoke(): Closure
    {
        return function (
            string|array $content,
            string $word = 'and',
            string $glue = ', ',
            ?string $translateFunction = null
        ): string {
            if (! is_array($content)) {
                $content = explode(',', $content);
                $content = array_map('trim', $content);
            }

            if (! $translateFunction && class_exists('Illuminate\Foundation\Application')) {
                $translateFunction = '__';
            }

            if ($translateFunction && function_exists($translateFunction)) {
                $word = call_user_func($translateFunction, $word);
            }

            return Arr::join($content, $glue, ' '.$word.' ');
        };
    }
}
