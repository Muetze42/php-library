<?php

namespace NormanHuth\Library;

use NormanHuth\Library\ClassFinder\ClassFinder as Instance;

/**
 * @method static array load(array|string $paths, ?string $subClassOf = null, ?string $classUses = null)
 *
 * @see \NormanHuth\Library\ClassFinder\ClassFinder::load()
 *
 * @method static string classFromFile(string $file)
 *
 * @see \NormanHuth\Library\ClassFinder\ClassFinder::classFromFile()
 */
class ClassFinder
{
    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
