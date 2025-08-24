<?php

namespace NormanHuth\Library\Traits\Enums;

/**
 * @template TEnum of \BackedEnum
 * @template TEnumValue of int|string|float
 */
trait EnumerationsTrait
{
    /**
     * Get an array of enum values.
     *
     * @param  list<TEnum>  $cases
     *
     * @return list<TEnumValue>
     */
    public static function enumValues(array $cases): array
    {
        return array_map(static fn ($value) => $value->value, $cases);
    }

    /**
     * Get an array of enum names.
     *
     * @param  list<TEnum>  $cases
     *
     * @return list<string>
     */
    public static function enumNames(array $cases): array
    {
        return array_map(static fn ($value) => $value->name, $cases);
    }
}
