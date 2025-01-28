<?php

namespace NormanHuth\Library\Support\Time;

class Microsecond
{
    /**
     * Convert given seconds to seconds and return as integer.
     */
    public static function seconds(float $seconds = 1): int
    {
        return round($seconds * 1000000);
    }

    /**
     * Convert given minutes to seconds and return as integer.
     */
    public static function minutes(float $minutes = 1): int
    {
        return Second::minutes(static::seconds($minutes));
    }

    /**
     * Convert given hours to seconds and return as integer.
     */
    public static function hours(float $minutes = 1): int
    {
        return Second::hours(static::seconds($minutes));
    }

    /**
     * Convert given days to seconds and return as integer.
     */
    public static function days(float $minutes = 1): int
    {
        return Second::days(static::seconds($minutes));
    }

    /**
     * Convert given weeks to seconds and return as integer.
     */
    public static function weeks(float $minutes = 1): int
    {
        return Second::weeks(static::seconds($minutes));
    }
}
