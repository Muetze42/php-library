<?php

namespace NormanHuth\Library\Support\Macros\Models;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Carbon as LaravelCarbon;
use NormanHuth\Library\Exceptions\MacroAttributeException;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class ActiveAgoMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get the age of a model attribute.
         */
        return function (string $attribute = 'active_at'): ?string {
            if (! $this->hasAttribute($attribute)) {
                throw new MacroAttributeException(
                    sprintf('The model `%s` does not have an attribute `%s`', get_class($this), $attribute)
                );
            }

            $attribute = $this->getAttribute($attribute);

            if (is_null($attribute)) {
                return null;
            }

            if (! $attribute instanceof Carbon) {
                throw new MacroAttributeException(
                    sprintf('The attribute `%s` is not a Carbon instance', $attribute)
                );
            }

            return LaravelCarbon::now()->diffForHumans($attribute);
        };
    }
}
