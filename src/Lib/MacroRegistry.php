<?php

namespace NormanHuth\Library\Lib;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use NormanHuth\Library\Support\ClassFinder;

class MacroRegistry
{
    /**
     * Register all custom macro using invokable class in given path.
     */
    public static function registerInvokableMacrosInPath(string $path, string $target): void
    {
        /* @var \Illuminate\Support\Traits\Macroable|string $target */
        collect(ClassFinder::load(
            paths: $path,
            namespace: 'NormanHuth\Library\Macros\\' . basename($path),
            basePath: $path
        ))->each(fn ($class) => static::macro($class, $target));
    }

    /**
     * Register a custom macro using invokable class.
     */
    public static function macro(string $macroClass, string $macroableClass): void
    {
        $method = lcfirst(class_basename($macroClass));

        /**
         * @var \Illuminate\Support\Traits\Macroable $macroableClass
         */
        if (!method_exists($macroClass, '__invoke') || $macroableClass::hasMacro($method)) {
            return;
        }

        $macroableClass::macro($method, (new $macroClass())());
    }

    /**
     * Register all macros.
     */
    public static function registerAllMacros(): void
    {
        static::registerArrMacros();
        static::registerHttpResponseMacros();
        static::registerNumberMacros();
        static::registerStrMacros();
    }

    /**
     * Register all string macros.
     */
    public static function registerStrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Str',
            Str::class
        );
    }

    /**
     * Register all array macros.
     */
    public static function registerArrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Arr',
            Arr::class
        );
    }

    /**
     * Register all number macros.
     */
    public static function registerNumberMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Number',
            Number::class
        );
    }

    /**
     * Register all HTTP client response macros.
     */
    public static function registerHttpResponseMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Http/Response',
            Response::class
        );
    }
}
