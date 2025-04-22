<?php

namespace NormanHuth\Library\Support\Macros\Config;

use Closure;
use InvalidArgumentException;

/**
 * @mixin \Illuminate\Config\Repository
 */
class NullableBooleanMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get the specified boolean or null configuration value.
         */
        return function (string $key, string|Closure|null $default = null) {
            $value = $this->get($key, $default);

            if (is_null($value)) {
                return $default;
            }

            if (! is_bool($value)) {
                throw new InvalidArgumentException(
                    sprintf('Configuration value for key [%s] must be a string, %s given.', $key, gettype($value))
                );
            }

            return $value;
        };
    }
}
