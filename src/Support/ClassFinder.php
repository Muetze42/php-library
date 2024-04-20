<?php

namespace NormanHuth\Library\Support;

use NormanHuth\Library\Core\ClassFinder as Instance;

/**
 * @deprecated use \NormanHuth\Library\ClassFinder instead
 */
class ClassFinder
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
