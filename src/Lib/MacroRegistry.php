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
    public static function registerInvokableMacrosInPath(string $path, string $target, ?string $namespace = null): void
    {
        /* @var \Illuminate\Support\Traits\Macroable|string $target */
        collect(ClassFinder::load(
            paths: $path,
            namespace: $namespace,
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
        static::registerCarbonMacros();
        static::registerArrMacros();
        static::registerHttpResponseMacros();
        static::registerNumberMacros();
        static::registerStrMacros();
    }

    /**
     * Register all string macros.
     */
    public static function registerCarbonMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Carbon',
            Str::class,
            'NormanHuth\Library\Macros\Carbon'
        );
    }

    /**
     * Register all string macros.
     */
    public static function registerStrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Str',
            Str::class,
            'NormanHuth\Library\Macros\Str'
        );
    }

    /**
     * Register all array macros.
     */
    public static function registerArrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Arr',
            Arr::class,
            'NormanHuth\Library\Macros\Arr'
        );
    }

    /**
     * Register all number macros.
     */
    public static function registerNumberMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Number',
            Number::class,
            'NormanHuth\Library\Macros\Number'
        );
    }

    /**
     * Register all HTTP client response macros.
     */
    public static function registerHttpResponseMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Macros/Http/Response',
            Response::class,
            'NormanHuth\Library\Macros\Http\Response'
        );
    }
}
