<?php

namespace NormanHuth\Library\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Deprecated;
use NormanHuth\Library\Lib\MacroRegistry;
use NormanHuth\Library\Support\Macros\Str\SplitNewLinesMacro;
use ReflectionClass;
use SplFileInfo;
use NormanHuth\Library\Filesystem;

class ClassFinder
{
    /**
     * Get all classes from the given paths.
     *
     * @param  string|null  $subClassOf  Return classes that has this class as one of its parents or implements it
     * @param  string|null  $classUses  Return classes that use the traits used by the given class
     */
    public static function load(
        array|string $paths,
        ?string $subClassOf = null,
        ?string $classUses = null,
        #[Deprecated]
        ?string $namespace = null,
        #[Deprecated]
        ?string $basePath = null
    ): array {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return [];
        }

        $classes = [];

        print_r(
            Filesystem::allFiles($paths)
        );

        foreach (Filesystem::allFiles($paths, '*.php') as $file) {
            $class = static::classFromFile($file);

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
     * @throws \RuntimeException
     */
    public static function classFromFile(string $file): string
    {
        MacroRegistry::macro(SplitNewLinesMacro::class, Str::class);

        /** @noinspection PhpUndefinedMethodInspection */
        $lines = array_map(
            fn (string $lime) =>  preg_replace('/\s+/', ' ', trim($lime)),
            Str::splitNewLines(file_get_contents($file))
        );

        $namespace = '';

        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            if ($parts[0] == 'namespace') {
                $namespace = trim(explode(';', $parts[1])[0]);
                break;
            }
            if (in_array($parts[0], ['class', 'final', 'interface', 'trait', 'abstract'])) {
                break;
            }
        }

        return $namespace . '\\' . pathinfo($file, PATHINFO_FILENAME);
    }
}
