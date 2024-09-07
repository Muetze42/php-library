<?php

namespace NormanHuth\Library\Services\Translation;

use Illuminate\Translation\FileLoader as Loader;

class FileLoader extends Loader
{
    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string|null  $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null): array
    {
        $locale = $this->parseLocaleString($locale);

        return parent::load($locale, $group, $namespace);
    }

    /**
     * Load a namespaced translation group.
     *
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function loadNamespaced($locale, $group, $namespace = null): array
    {
        $locale = $this->parseLocaleString($locale);

        return parent::loadNamespaced($locale, $group, $namespace);
    }

    /**
     * Load a local namespaced translation group for overrides.
     *
     * @param  array  $lines
     * @param  string  $locale
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function loadNamespaceOverrides(array $lines, $locale, $group, $namespace): array
    {
        $locale = $this->parseLocaleString($locale);

        return parent::loadNamespaceOverrides($lines, $locale, $group, $namespace);
    }

    /**
     * Load a locale from a given path.
     *
     * @param  array  $paths
     * @param  string  $locale
     * @param  string  $group
     * @return array
     */
    public function loadPaths(array $paths, $locale, $group): array
    {
        $locale = $this->parseLocaleString($locale);

        return parent::loadPaths($paths, $locale, $group);
    }

    /**
     * Get parsed locale string.
     *
     * @param  string  $locale
     * @return string
     */
    protected function parseLocaleString(string $locale): string
    {
        return explode('-', str_replace('_', '-', $locale))[0];
    }
}
