<?php

/** @noinspection PhpComposerExtensionStubsInspection */

namespace NormanHuth\Library;

use Illuminate\Support\Arr;
use ZipArchive;

class Zip
{
    /**
     * The active archive instance.
     */
    public ZipArchive $archive;

    /**
     * @param  string  $target  The target ZIP archive file.
     * @param  bool  $overwrite  Always start a new archive, this mode will overwrite the file if it already exists.
     */
    public function __construct(string $target, bool $overwrite = true)
    {
        $this->archive = new ZipArchive();
        $this->archive->open($target, $overwrite ? ZIPARCHIVE::CREATE : ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
    }

    /**
     * Add a file to a ZIP archive using its contents.
     */
    public function addFromString(
        string $name,
        string $content,
        int $flags = ZipArchive::FL_OVERWRITE
    ): static {
        $this->archive->addFromString($name, $content, $flags);

        return $this;
    }

    /**
     * Adds a file to a ZIP archive from the given path.
     */
    public function addFile(string $filepath, string $entryName, int $flags = ZipArchive::FL_OVERWRITE): static
    {
        $this->archive->addFile($filepath, $entryName, flags: $flags);

        return $this;
    }

    /**
     * Add files from a directory by glob pattern.
     */
    public function addGlob(string $pattern, int $flags = 0, array $options = []): static
    {
        $this->archive->addGlob($pattern, $flags, $options);

        return $this;
    }

    /**
     * Add files from a directory by PCRE pattern.
     */
    public function addPattern(string $pattern, string $path = '.', array $options = []): static
    {
        $this->archive->addPattern($pattern, $path, $options);

        return $this;
    }

    /**
     * Add a directory to a ZIP archive.
     */
    public function addDirectory(string $path, array $excludeFiles = []): static
    {
        $excludeFiles = Arr::map(array_filter($excludeFiles), fn (string $file) => str_replace('\\', '/', $file));
        collect(Filesystem::allFiles($path))
            ->filter(fn (string $file) => ! in_array(str_replace('\\', '/', $file), $excludeFiles))
            ->each(fn (string $file) => $this->archive->addFile($file, substr($file, strlen($path) + 1)));

        return $this;
    }

    /**
     * Add an empty directory to a ZIP archive.
     */
    public function addEmptyDir(string $dirname, int $flags = 0): static
    {
        $this->archive->addEmptyDir($dirname, $flags);

        return $this;
    }

    /**
     * Get the archive instance.
     */
    public function archive(): ZipArchive
    {
        return $this->archive;
    }

    /**
     * Close the active archive.
     */
    public function close(): static
    {
        $this->archive->close();

        return $this;
    }

    /**
     * Compress a directory to a ZIP archive.
     */
    public static function compressDirectory(
        string $target,
        string $path,
        array $excludeFiles = [],
        bool $overwrite = true
    ): ZipArchive {
        return (new static($target, $overwrite))->addDirectory($path, $excludeFiles)->close()->archive();
    }
}
