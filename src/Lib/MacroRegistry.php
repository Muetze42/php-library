<?php

namespace NormanHuth\Library\Lib;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
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
        if (! method_exists($macroClass, '__invoke') || $macroableClass::hasMacro($method)) {
            return;
        }

        $macroableClass::macro($method, (new $macroClass())());
    }

    /**
     * Register an array of custom macros using invokable class.
     *
     * @param  array<class-string, class-string>  $macroMacroableClasses
     */
    public static function macros(array $macroMacroableClasses): void
    {
        foreach ($macroMacroableClasses as $macroClass => $macroableClass) {
            static::macro($macroClass, $macroableClass);
        }
    }

    /**
     * Register all macros from /src/Support/Macros directory.
     *
     * @deprecated There is no use case where all macros are needed.
     */
    public static function registerAllMacros(): void
    {
        static::registerArrMacros();
        static::registerCarbonMacros();
        static::registerCollectionMacros();
        static::registerConfigMacros();
        static::registerHttpResponseMacros();
        static::registerNumberMacros();
        static::registerRequestMacros();
        static::registerStrMacros();
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
     * Register all carbon macros.
     */
    public static function registerCarbonMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Carbon',
            Carbon::class
        );
    }

    /**
     * Register all collection macros.
     */
    public static function registerCollectionMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Collection',
            Collection::class
        );
    }

    /**
     * Register all config macros.
     */
    public static function registerConfigMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Config',
            Config::class
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
     * Register all request macros.
     */
    public static function registerRequestMacros(): void
    {
        static::registerInvokableMacrosInPath(
            dirname(__FILE__, 2) . '/Support/Macros/Request',
            Request::class
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
}
