<?php

namespace NormanHuth\Library\Support\Time;

class Minute
{
    /**
     * Convert given minutes to minutes and return as integer.
     */
    public static function seconds(float $seconds = 1): int
    {
        return round($seconds * 60);
    }

    /**
     * Convert given hours to seconds and return as integer.
     */
    public static function hours(float $minutes = 1): int
    {
        return Second::hours(static::seconds($minutes));
    }

    /**
     * Convert given days to minutes and return as integer.
     */
    public static function days(float $minutes = 1): int
    {
        return Second::days(static::seconds($minutes));
    }

    /**
     * Convert given weeks to minutes and return as integer.
     */
    public static function weeks(float $minutes = 1): int
    {
        return Second::weeks(static::seconds($minutes));
    }

    /**
     * Convert weeks microseconds to minutes and return as integer.
     */
    public static function microseconds(float $microseconds = 1): int
    {
        return Second::microseconds(static::seconds($microseconds));
    }
}
