<?php

namespace NormanHuth\Library\Support\Time;

class Second
{
    /**
     * Convert given minutes to seconds and return as integer.
     */
    public static function minutes(float $minutes = 1): int
    {
        return round($minutes * 60);
    }

    /**
     * Convert given hours to seconds and return as integer.
     */
    public static function hours(float $hours = 1): int
    {
        return static::minutes($hours * 60);
    }

    /**
     * Convert given days to seconds and return as integer.
     */
    public static function days(float $days = 1): int
    {
        return static::hours($days * 24);
    }

    /**
     * Convert weeks hours to seconds and return as integer.
     */
    public static function weeks(float $weeks = 1): int
    {
        return static::days($weeks * 7);
    }
}
