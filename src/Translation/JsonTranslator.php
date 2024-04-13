<?php

namespace NormanHuth\Library\Translation;

use Illuminate\Support\Arr;

class JsonTranslator
{
    /**
     * Get all JSON translation.
     */
    public static function getJsonTranslations(
        ?string $locale = null,
        string $group = '*',
        ?string $namespace = '*'
    ): array {
        if (!$locale) {
            $locale = app()->getLocale();
        }

        $loader = app('translator')->getLoader();

        return $loader->load($locale, $group, $namespace);
    }

    /**
     * Add new JSON paths include child paths to the translation file loader.
     */
    public static function loadJsonTranslationsFrom(array|string $paths): void
    {
        $paths = array_unique(Arr::wrap($paths));

        foreach ($paths as $path) {
            $path = rtrim($path, '\\/');
            app('translator')->addJsonPath($path);
            foreach (glob($path . '/*', GLOB_ONLYDIR) as $childPath) {
                self::loadJsonTranslationsFrom($childPath);
            }
        }
    }
}
