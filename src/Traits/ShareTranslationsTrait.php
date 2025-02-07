<?php

namespace NormanHuth\Library\Traits;

trait ShareTranslationsTrait
{
    /**
     * Load the messages for the given locale.
     *
     * @return array<string, string>
     */
    protected function jsonTranslations(): array
    {
        return app('translator')
            ->getLoader()
            ->load(app()->getLocale(), '*', '*');
    }
}
