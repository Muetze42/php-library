<?php

namespace NormanHuth\Library;

use NormanHuth\Library\Filesystem\Filesystem as Instance;

/**
 * @method static array allDirectories(string|array $paths, bool $hidden = true)
 *
 * @see \NormanHuth\Library\Filesystem\Filesystem::allDirectories()
 *
 * @method static array allFiles(string|array $paths, string $pattern = '*', bool $hidden = true)
 *
 * @see \NormanHuth\Library\Filesystem\Filesystem::allFiles()
 *
 * @method static bool deleteDirectory(string $path): bool
 *
 * @see \NormanHuth\Library\Filesystem\Filesystem::deleteDirectory()
 */
class Filesystem
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
