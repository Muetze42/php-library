<?php

namespace NormanHuth\Library;

class Package
{
    /**
     * Get the path to the base of the package.
     */
    public static function patch(): string
    {
        return dirname(__FILE__);
    }
}
