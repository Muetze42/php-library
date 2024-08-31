<?php

namespace NormanHuth\Library\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;
use NormanHuth\Library\Services\Translation\FileLoader;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader(): void
    {
        $this->app->singleton('translation.loader', function (Application $app) {
            return new FileLoader($app['files'], [__DIR__ . '/lang', $app['path.lang']]);
        });
    }
}
