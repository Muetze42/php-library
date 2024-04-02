<?php

namespace NormanHuth\Library\Support;

use Illuminate\Support\Arr;

class ComposerJson
{
    /**
     * The composer.json properties ordered by https://schema.org.
     *
     * @var array|string[]
     */
    public static array $properties = [
        'name',
        'description',
        'license',
        'type',
        'abandoned',
        'version',
        'default-branch',
        'non-feature-branches',
        'keywords',
        'readme',
        'time',
        'authors',
        'homepage',
        'support',
        'funding',
        'source',
        'dist',
        '_comment',
        'require',
        'require-dev',
        'replace',
        'conflict',
        'provide',
        'suggest',
        'repositories',
        'minimum-stability',
        'prefer-stable',
        'autoload',
        'autoload-dev',
        'target-dir',
        'include-path',
        'bin',
        'archive',
        'php-ext',
        'config',
        'extra',
        'scripts',
        'scripts-descriptions',
        'scripts-aliases',
    ];

    public static function sort(array $data, bool $sortPackages = true, bool $sortKeywords = true): array
    {
        $properties = Arr::mapWithKeys(
            static::$properties,
            fn (string $value, int $key) => [$value => sprintf('%02d', $key)]
        );

        $data = Arr::mapWithKeys(
            $data,
            fn (mixed $item, string $key) => [data_get($properties, $key, 99) . $key => $item]
        );

        ksort($data);

        $data = Arr::mapWithKeys(
            $data,
            fn (mixed $item, string $key) => [substr($key, 2) => $item]
        );

        if ($sortPackages) {
            foreach (['require', 'require-dev'] as $property) {
                if (empty($data[$property])) {
                    continue;
                }
                data_set($data, $property, static::sortPackages($data[$property]));
            }
        }

        if ($sortKeywords) {
            if (!empty($data['keywords'])) {
                $data['keywords'] = array_values(Arr::sort($data['keywords']));
            }
        }

        return $data;
    }

    public static function sortPackages(array $data): array
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
