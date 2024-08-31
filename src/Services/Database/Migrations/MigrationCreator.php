<?php

namespace NormanHuth\Library\Services\Database\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as Creator;

class MigrationCreator extends Creator
{
    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix(): string
    {
        $int = 0;
        $files = glob(database_path('migrations/*'));
        $today = now()->format('Y_m_d_');
        foreach ($files as $file) {
            $file = basename($file);
            if (str_starts_with($file, $today)) {
                $int = (int) substr($file, 11, 6);
            }
        }

        $int = ceil($int / 10) * 10;

        return $today . str_pad($int + 10, 6, 0, STR_PAD_LEFT);
    }
}
