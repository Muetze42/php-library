<?php

namespace NormanHuth\Library\Filesystem;

use FilesystemIterator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SplFileInfo;

class Filesystem
{
    /**
     * Get all directories from the given paths (recursive).
     */
    public function allDirectories(string|array $paths, bool $hidden = false): array
    {
        $directories = Arr::flatten(Arr::map(
            (array) $paths,
            fn ($path) => collect(iterator_to_array(new FilesystemIterator($path)))
                ->filter(function (SplFileInfo $item) {
                    return $item->isDir() && ! $item->isLink();
                })
                ->map(fn (SplFileInfo $item) => $item->getPathname())
                ->when($hidden, fn ($items) => $items->filter(fn ($item) => ! Str::startsWith(basename($item), '.')))
                ->values()
                ->toArray()
        ));

        foreach ($directories as $directory) {
            $directories = array_merge($directories, $this->allDirectories($directory));
        }

        return $directories;
    }

    /**
     * Get all files from the given paths (recursive).
     */
    public function allFiles(string|array $paths, string $pattern = '*', bool $hidden = false): array
    {
        $paths = (array) $paths;
        $paths = array_merge($paths, $this->allDirectories($paths));

        $files = Arr::flatten(Arr::map(
            $paths,
            fn ($path) => glob(rtrim($path, '/\\') . DIRECTORY_SEPARATOR . $pattern)
        ));

        if ($hidden) {
            $files = Arr::where(
                $files,
                fn ($file) => ! Str::startsWith(basename($file), '.')
            );
        }

        return Arr::where($files, fn ($file) => ! is_dir($file));
    }

    /**
     * Delete the given directory (recursive).
     */
    public function deleteDirectory(string $directory): bool
    {
        if (! is_dir($directory)) {
            return false;
        }

        /* @var array<\SplFileInfo> $items */
        $items = new FilesystemIterator($directory);

        foreach ($items as $item) {
            if ($item->isDir() && ! $item->isLink()) {
                $this->deleteDirectory($item->getPathname());

                continue;
            }

            @unlink($item->getPathname());
        }

        @rmdir($directory);

        return true;
    }
}
