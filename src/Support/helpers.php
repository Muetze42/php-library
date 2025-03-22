<?php

namespace NormanHuth\Library\Support;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Convert time-string (1d, 1w, 1y) to minutes.
 *
 * @example stringToMinutes('2d') for 2 days.
 * @example stringToMinutes('2w') for 2 weeks.
 * @example stringToMinutes('2m') for 2 month.
 * @example stringToMinutes('2y') for 2 years.
 */
function toMinutes(string|int|float $value): int
{
    if (is_numeric($value)) {
        return (int) round((float) $value);
    }

    $value = (string) $value;

    $minutes = (string) preg_replace('/\D/', '', $value);
    $formatCharacter = Str::lower(str_replace($minutes, '', $value));

    if (empty($formatCharacter)) {
        return (int) round((float) $minutes);
    }

    $minutes = (int) $minutes;

    return match ($formatCharacter) {
        'd' => $minutes * 1440,
        'w' => $minutes * 10080,
        'm' => $minutes * 43830,
        'y' => $minutes * 525960,
        default => throw new InvalidArgumentException("Invalid format character '{$formatCharacter}'"),
    };
}
