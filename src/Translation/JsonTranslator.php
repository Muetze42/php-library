<?php

namespace NormanHuth\Library\Translation;

use Illuminate\Support\Arr;

class JsonTranslator
{
    /**
     * Get all JSON translation.
     *
     * @param  string|null  $locale
     * @param  string  $group
     * @param  string|null  $namespace
     * @return array<string, string>
     */
    public static function getJsonTranslations(
        ?string $locale = null,
        string $group = '*',
        ?string $namespace = '*'
    ): array {
        if (! $locale) {
            $locale = app()->getLocale();
        }

        $loader = app('translator')->getLoader();

        return $loader->load($locale, $group, $namespace);
    }

    /**
     * Add new JSON paths include child paths to the translation file loader.
     *
     * @param  string|string[]  $paths
     */
    public static function loadJsonTranslationsFrom(array|string $paths): void
    {
        $paths = array_unique(Arr::wrap($paths));

        foreach ($paths as $path) {
            $path = rtrim($path, '\\/');
            app('translator')->addJsonPath($path);
            $childPaths = glob($path . '/*', GLOB_ONLYDIR);
            if (! $childPaths) {
                continue;
            }
            foreach ($childPaths as $childPath) {
                self::loadJsonTranslationsFrom($childPath);
            }
        }
    }
}
