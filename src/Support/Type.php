<?php

namespace NormanHuth\Library\Support;

use NormanHuth\Library\Exceptions\InvalidArgumentException;

class Type
{
    /**
     * Ensures the given value is a string.
     *
     * @param  mixed  $value  The value to check.
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function ensureString(mixed $value): string
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('Value must be a string.');
        }

        return $value;
    }

    /**
     * Ensures the given value is a string or null.
     *
     * @param  mixed  $value  The value to check.
     * @return string|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableString(mixed $value): ?string
    {
        if (! is_null($value) && ! is_string($value)) {
            throw new InvalidArgumentException('Value must be a string or null.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an integer.
     *
     * @param  mixed  $value  The value to check.
     * @return int
     *
     * @throws InvalidArgumentException
     */
    public static function ensureInt(mixed $value): int
    {
        if (! is_int($value)) {
            throw new InvalidArgumentException('Value must be a integer.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an integer or null.
     *
     * @param  mixed  $value  The value to check.
     * @return int|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableInt(mixed $value): ?int
    {
        if (! is_null($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Value must be a integer or null.');
        }

        return $value;
    }

    /**
     * Ensures the given value is a boolean.
     *
     * @param  mixed  $value  The value to check.
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public static function ensureBool(mixed $value): bool
    {
        if (! is_bool($value)) {
            throw new InvalidArgumentException('Value must be a boolean.');
        }

        return $value;
    }

    /**
     * Ensures the given value is a boolean or null.
     *
     * @param  mixed  $value  The value to check.
     * @return bool|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableBool(mixed $value): ?bool
    {
        if (! is_null($value) && ! is_bool($value)) {
            throw new InvalidArgumentException('Value must be a boolean or null.');
        }

        return $value;
    }

    /**
     * Ensures the given value is a float.
     *
     * @param  mixed  $value  The value to check.
     * @return float
     *
     * @throws InvalidArgumentException
     */
    public static function ensureFloat(mixed $value): float
    {
        if (! is_float($value)) {
            throw new InvalidArgumentException('Value must be a float.');
        }

        return $value;
    }

    /**
     * Ensures the given value is a float or null.
     *
     * @param  mixed  $value  The value to check.
     * @return float|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableFloat(mixed $value): ?float
    {
        if (! is_null($value) && ! is_float($value)) {
            throw new InvalidArgumentException('Value must be a float or null.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an object.
     *
     * @param  mixed  $value  The value to check.
     * @return object
     *
     * @throws InvalidArgumentException
     */
    public static function ensureObject(mixed $value): object
    {
        if (! is_object($value)) {
            throw new InvalidArgumentException('Value must be a object.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an object or null.
     *
     * @param  mixed  $value  The value to check.
     * @return object|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableObject(mixed $value): ?object
    {
        if (! is_null($value) && ! is_object($value)) {
            throw new InvalidArgumentException('Value must be a object or null.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an array.
     *
     * @template TArray of array
     *
     * @param  TArray  $value  The value to check.
     * @return TArray
     *
     * @throws InvalidArgumentException
     */
    public static function ensureArray(mixed $value): array
    {
        if (! is_array($value)) {
            throw new InvalidArgumentException('Value must be an array.');
        }

        return $value;
    }

    /**
     * Ensures the given value is an array or null.
     *
     * @template TArray of array
     *
     * @param  TArray|null  $value  The value to check.
     * @return TArray|null
     *
     * @throws InvalidArgumentException
     */
    public static function ensureNullableArray(mixed $value): ?array
    {
        // @phpstan-ignore-next-line
        if (! is_null($value) && ! is_array($value)) {
            throw new InvalidArgumentException('Value must be an array or null.');
        }

        return $value;
    }
}
