<?php

namespace NormanHuth\Library\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait LivewireTrait
{
    /**
     * The attributes that shouldn't trim.
     *
     * @return string[]
     */
    protected function exceptFromTrimStrings(): array
    {
        return [
            'current_password',
            'password',
            'password_confirmation',
        ];
    }

    /**
     * The attributes that shouldn't transform to null if empty string.
     *
     * @return string[]
     */
    protected function exceptFromConvertEmptyStringsToNull(): array
    {
        return [];
    }

    /**
     * Transform the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    protected function transformAttributesForValidation(array $attributes): array
    {
        return $this->convertEmptyStringsToNullTransform(
            $this->trimStringsTransform($attributes)
        );
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    protected function trimStringsTransform(array $attributes): array
    {
        return Arr::map($attributes, fn (mixed $value, string $key): mixed => $this->trimString($key, $value));
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    protected function convertEmptyStringsToNullTransform(array $attributes): array
    {
        return Arr::map($attributes, fn (mixed $value, string $key): mixed => $this->convertEmptyStringToNull($key, $value));
    }

    /**
     * Transform the given value.
     *
     *
     */
    protected function trimString(string $key, mixed $value): mixed
    {
        if (is_array($value)) {
            return Arr::map($value, fn (array $value): array => $this->trimString($key, $value));
        }

        if ($this->shouldSkipTrimString($key, $value)) {
            return $value;
        }

        return Str::trim($value);
    }

    /**
     * Transform the given value.
     */
    protected function convertEmptyStringToNull(string $key, mixed $value): mixed
    {
        if (is_array($value)) {
            return Arr::map($value, fn (array $value): array => $this->convertEmptyStringToNull($key, $value));
        }

        if ($this->shouldSkipConvertEmptyStringToNull($key, $value)) {
            return $value;
        }

        return empty($value) ? null : $value;
    }

    /**
     * Determine if the given key should skip.
     */
    protected function shouldSkipTrimString(string $key, mixed $value): bool
    {
        return ! is_string($value) || in_array($key, $this->exceptFromTrimStrings(), true);
    }

    /**
     * Determine if the given key should skip.
     */
    protected function shouldSkipConvertEmptyStringToNull(string $key, mixed $value): bool
    {
        return ! is_string($value) || in_array($key, $this->exceptFromConvertEmptyStringsToNull(), true);
    }
}
