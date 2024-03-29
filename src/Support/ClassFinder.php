<?php

namespace NormanHuth\Library\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ClassFinder
{
    /**
     * Get all classes from the given paths.
     *
     * @source https://github.com/laravel/framework/blob/11.x/src/Illuminate/Foundation/Console/Kernel.php#L348
     *
     * @param string|null  $subClassOf Return classes that has this class as one of its parents or implements it
     * @param string|null  $classUses  Return classes that use the traits used by the given class
     */
    public static function load(
        array|string $paths,
        ?string $subClassOf = null,
        ?string $classUses = null,
        ?string $namespace = null,
        ?string $basePath = null,
    ): array {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return [];
        }

        $classes = [];

        foreach (Finder::create()->in($paths)->files()->name('*.php') as $file) {
            $class = static::classFromFile($file, $namespace, $basePath);
            if (!class_exists($class)) {
                continue;
            }
            if (!(new ReflectionClass($class))->isInstantiable()) {
                continue;
            }
            if ($subClassOf && !is_subclass_of($class, $subClassOf)) {
                continue;
            }
            if ($classUses && !in_array($classUses, class_uses_recursive($class))) {
                continue;
            }

            $classes[] = $class;
        }

        return $classes;
    }

    /**
     * Extract the class name from the given file path.
     *
     * @source https://github.com/laravel/framework/blob/11.x/src/Illuminate/Foundation/Console/Kernel.php#L348
     */
    public static function classFromFile(SplFileInfo $file, ?string $namespace = null, ?string $basePath = null): string
    {
        if (!$namespace) {
            $namespace = app()->getNamespace();
        }

        if (!$basePath) {
            $basePath = app_path();
        }

        if (!str_ends_with($namespace, '\\')) {
            $namespace .= '\\';
        }

        $basePath = rtrim($basePath, '/\\');

        return $namespace . str_replace(
            ['/', '.php'],
            ['\\', ''],
            Str::after($file->getRealPath(), realpath($basePath) . DIRECTORY_SEPARATOR)
        );
    }
}
