<?php

namespace NormanHuth\Library;

use NormanHuth\Library\Support\Filesystem as FilesystemInstance;

/**
 * @method allDirectories(string|array $paths, bool $hidden = true): array
 * @method allFiles(string|array $paths, string $pattern = '*', bool $hidden = true): array
 */
class Filesystem
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (new FilesystemInstance())->$name(...$arguments);
    }
}
