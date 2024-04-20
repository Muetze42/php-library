<?php

namespace NormanHuth\Library\Lib;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use NormanHuth\Library\ClassFinder;

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
        ))->each(fn ($class) => static::macro($class, $target));
    }

    /**
     * Register a custom macro using invokable class.
     */
    public static function macro(string $macroClass, string $macroableClass): void
    {
        $method = lcfirst(class_basename($macroClass));

        if (str_ends_with($method, 'Macro') && strlen($method) > 5) {
            $method = substr($method, 0, -5);
        }

        /**
         * @var \Illuminate\Support\Traits\Macroable $macroableClass
         */
        if (!method_exists($macroClass, '__invoke') || $macroableClass::hasMacro($method)) {
            return;
        }

        $macroableClass::macro($method, (new $macroClass())());
    }

    /**
     * Register an array of custom macros using invokable class.
     *
     *  @param array<class-string, class-string>  $macroMacroableClasses
     */
    public static function macros(array $macroMacroableClasses): void
    {
        foreach ($macroMacroableClasses as $macroClass => $macroableClass) {
            static::macro($macroClass, $macroableClass);
        }
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
            dirname(__FILE__, 2) . '/Support/Macros/Carbon',
            Str::class
        );
    }

    /**
     * Register all string macros.
     */
    public static function registerStrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Str',
            Str::class
        );
    }

    /**
     * Register all array macros.
     */
    public static function registerArrMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Arr',
            Arr::class
        );
    }

    /**
     * Register all number macros.
     */
    public static function registerNumberMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Number',
            Number::class
        );
    }

    /**
     * Register all HTTP client response macros.
     */
    public static function registerHttpResponseMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Http/Response',
            Response::class
        );
    }
}
