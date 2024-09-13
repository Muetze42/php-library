<?php

namespace NormanHuth\Library\Support\Macros\Models;

use Closure;
use Illuminate\Support\Carbon;
use NormanHuth\Library\Exceptions\MacroAttributeException;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class AgeMacro
{
    public function __invoke(): Closure
    {
        /**
         * Get the age of a model attribute.
         */
        return function (string $attribute = 'birthday'): ?int {
            if (! $this->hasAttribute($attribute)) {
                throw new MacroAttributeException(
                    sprintf('The model `%s` does not have an attribute `%s`', get_class($this), $attribute)
                );
            }

            $value = $this->getAttribute($attribute);

            if (is_null($value)) {
                return null;
            }

            if (! $value instanceof Carbon) {
                throw new MacroAttributeException(
                    sprintf('The attribute `%s` is not a Carbon instance', $attribute)
                );
            }

            $now = Carbon::now();
            $value->setYear($now->year);

            if ($value->year < $now->year) {
                $value->addYear();
            }

            return $now->diffInYears($value);
        };
    }
}
