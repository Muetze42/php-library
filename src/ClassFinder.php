<?php

namespace NormanHuth\Library;

use NormanHuth\Library\ClassFinder\ClassFinder as Instance;

/**
 * @method load(array|string $paths, ?string $subClassOf = null, ?string $classUses = null): array
 * @see \NormanHuth\Library\ClassFinder\ClassFinder::load()
 * @method classFromFile(string $file): string
 * @see \NormanHuth\Library\ClassFinder\ClassFinder::classFromFile()
 */
class ClassFinder
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
