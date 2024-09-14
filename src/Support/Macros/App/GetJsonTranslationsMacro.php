<?php

namespace NormanHuth\Library\Support\Macros\App;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Translation\Translator;
use Throwable;

/**
 * @mixin \Illuminate\Foundation\Application
 */
class GetJsonTranslationsMacro
{
    public function __invoke(): Closure
    {
        /**
         * Load the messages for the given locale.
         *
         * @return array<string, string>
         */
        return function (): array {
            try {
                $bind = $this->has('translator') ? $this->get('translator') : null;

                return $bind instanceof Translator ? $bind->getLoader()
                    ->load(substr($this->getLocale(), 0, 2), '*', '*') : [];
            } catch (Throwable $throwable) {
                Log::error($throwable->getMessage(), $throwable->getTrace());

                return [];
            }
        };
    }
}
