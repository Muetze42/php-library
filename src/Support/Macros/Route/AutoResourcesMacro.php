<?php

namespace NormanHuth\Library\Support\Macros\Route;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Facades\Route
 */
class AutoResourcesMacro
{
    /**
     * Register an array of resource controllers with automatic resource names.
     *
     * @return \Closure(array<class-string>, array<string, mixed>): void
     */
    public function __invoke(): Closure
    {
        /**
         * @param list<class-string> $resources
         * @param array<string, mixed> $options
         */
        return function (array $resources, array $options = []) {
            $resources = Arr::mapWithKeys($resources, static function (string $controller) {
                $name = Str::of(class_basename($controller))
                    ->replace('Controller', '')
                    ->kebab()
                    ->plural()
                    ->value();

                return [$name => $controller];
            });

            $this->resources($resources, $options);
        };
    }
}
