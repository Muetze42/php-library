<?php

namespace NormanHuth\Library;

use NormanHuth\Library\Core\ClassFinder as Instance;

/**
 * phpcs:disable.
 *
 * @method load(array|string $paths, ?string $subClassOf = null, ?string $classUses = null, ?string $basePath = null): array
 * @method classFromFile(string $file): string
 * phpcs:enable
 */
class ClassFinder
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
