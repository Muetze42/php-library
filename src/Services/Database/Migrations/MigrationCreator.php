<?php

namespace NormanHuth\Library\Services\Database\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as Creator;
use Illuminate\Filesystem\Filesystem;

class MigrationCreator extends Creator
{
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
        $int = 0;
        $files = glob(database_path('migrations/*'));
        $today = now()->format('Y_m_d_');

        if (is_array($files)) {
            foreach ($files as $file) {
                $file = basename($file);
                if (str_starts_with($file, $today)) {
                    $int = (int) substr($file, 11, 6);
                }
            }
        }

        $int = (ceil($int / 10) * 10) + 10;

        return $today . str_pad((string) $int, 6, '0', STR_PAD_LEFT);
    }
}
