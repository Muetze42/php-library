<?php

namespace NormanHuth\Library;

use NormanHuth\Library\Core\Filesystem as Instance;

/**
 * @method allDirectories(string|array $paths, bool $hidden = true): array
 * @method allFiles(string|array $paths, string $pattern = '*', bool $hidden = true): array
 */
class Filesystem
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new Instance())->$name(...$arguments);
    }
}
