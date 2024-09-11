<?php

namespace NormanHuth\Library\Services\Database\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as Creator;
use Illuminate\Filesystem\Filesystem;

class MigrationCreator extends Creator
{
    /**
     * @var string
     */
    protected string $formattedToday;

    /**
     * Create a new migration creator instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string|null  $customStubPath
     * @return void
     */
    public function __construct(Filesystem $files, ?string $customStubPath = null)
    {
        if (! $customStubPath) {
            $customStubPath = base_path('stubs');
        }

        parent::__construct($files, $customStubPath);
    }

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix(): string
    {
        return static::getFormattedDatePrefix();
    }

    /**
     * Get a formatted date prefix for the migration.
     *
     * @return string
     */
    public static function getFormattedDatePrefix(): string
    {
        $files = glob(database_path('migrations/*'));
        $today = now()->format('Y_m_d_');
        $files = array_filter($files, fn (string $file) => static::isFileFromToday($file, $today));

        return $today . str_pad((count($files) + 1) * 10, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @param  string  $file
     * @param  string  $today
     * @return bool
     */
    protected static function isFileFromToday(string $file, string $today): bool
    {
        return str_starts_with(basename($file), $today) && ! str_starts_with(basename($file), $today . '00000');
    }
}
