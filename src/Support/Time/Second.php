<?php

namespace NormanHuth\Library\Support\Time;

class Second
{
    /**
     * Convert given minutes to seconds and return as integer.
     */
    public static function minutes(float $minutes = 1): float
    {
        return $minutes * 60;
    }

    /**
     * Convert given hours to seconds and return as integer.
     */
    public static function hours(float $hours = 1): float
    {
        return $hours * 3600;
    }

    /**
     * Convert given days to seconds and return as integer.
     */
    public static function days(float $days = 1): float
    {
        return $days * 86400;
    }

    /**
     * Convert weeks hours to seconds and return as integer.
     */
    public static function weeks(float $weeks = 1): float
    {
        return $weeks * 604800;
    }

    /**
     * Convert weeks microseconds to seconds and return as integer.
     */
    public static function microseconds(float $microseconds = 1): float
    {
        return $microseconds / 1000000;
    }
}
