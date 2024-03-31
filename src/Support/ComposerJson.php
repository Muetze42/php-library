<?php

namespace NormanHuth\Library\Support;

use Illuminate\Support\Arr;

class ComposerJson
{
    public static array $structure = [
        'name',
        'type',
        'description',
        'version',
        'keywords',
        'homepage',
        'readme',
        'support',
        'funding',
        'time',
        'license',
        'authors',
        'require',
        'require-dev',
        'autoload',
        'autoload-dev',
        'repositories',
        'conflict',
        'replace',
        'provide',
        'suggest',
        'config',
        'extra',
        'bin',
        'include-path',
        'target-dir',
        'scripts',
        'scripts-descriptions',
        'minimum-stability',
        'prefer-stable',
        'archive',
        'abandoned',
        '_comment',
        'non-feature-branches',
    ];

    public static function setStructure(array $structure): void
    {
        static::$structure = $structure;
    }

    public static function sort(array $data): array
    {
        static::$structure = Arr::mapWithKeys(
            static::$structure,
            fn (string $value, int $key) => [$value => sprintf('%02d', $key)]
        );

        $data = Arr::mapWithKeys(
            $data,
            fn (mixed $item, string $key) => [data_get(static::$structure, $key, 99) . $key => $item]
        );

        ksort($data);

        $data = Arr::mapWithKeys(
            $data,
            fn (mixed $item, string $key) => [substr($key, 2) => $item]
        );

        foreach (['require', 'require-dev'] as $property) {
            if (empty($data[$property])) {
                continue;
            }
            data_set($data, $property, static::sortRequirements($data[$property]));
        }

        if (!empty($data['keywords'])) {
            $data['keywords'] = array_values(Arr::sort($data['keywords']));
        }

        return $data;
    }

    public static function sortRequirements(array $data): array
    {
        $data = Arr::mapWithKeys(
            $data,
            function (mixed $item, string $key) {
                if (str_contains($key, '/')) {
                    $key = 3 . $key;
                } elseif (str_contains($key, '-')) {
                    $key = 2 . $key;
                } else {
                    $key = 1 . $key;
                }

                return [$key => $item];
            }
        );

        ksort($data);

        return Arr::mapWithKeys(
            $data,
            fn (mixed $item, string $key) => [substr($key, 1) => $item]
        );
    }
}
