<?php

namespace NormanHuth\Library;

use Illuminate\Support\Str;

class Tailwind
{
    /**
     * The Tailwind CSS classes.
     *
     * @var array<int, string>
     */
    protected static array $classes;

    /**
     * Get all Tailwind CSS classes.
     *
     * @return array<int, string>
     *
     * @throws \Exception
     */
    public static function classes(): array
    {
        if (! isset(self::$classes)) {
            $contents = file_get_contents(
                dirname(__FILE__, 2) . '/data/tailwind-classes.json'
            );

            if (! $contents) {
                throw new \Exception('Unable to load tailwind classes.json');
            }

            static::$classes = json_decode($contents, true);
        }

        return static::$classes;
    }

    /**
     * Get the property of a Tailwind CSS class.
     */
    public static function property(string $class): ?string
    {
        return data_get(static::classes(), $class);
    }

    /**
     * Find a Tailwind CSS for a property.
     */
    public static function class(string $property): ?string
    {
        if (str_ends_with($property, ';')) {
            $property = substr($property, 0, -1);
        }

        return data_get(array_flip(static::classes()), $property);
    }

    /**
     * Get the hexadecimal string of a Tailwind CSS color.
     */
    public static function color(string $palette, int $shade): ?string
    {
        $class = data_get(static::classes(), 'text-' . Str::lower($palette) . '-' . $shade);

        if (! $class || ! str_contains($class, 'color: rgb')) {
            return null;
        }

        preg_match('/\((.*?)\)/', $class, $matches);

        if (! isset($matches[1])) {
            return null;
        }

        [$r, $g, $b] = sscanf($matches[1], '%d %d %d');

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
