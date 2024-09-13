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

            $attribute = $this->getAttribute($attribute);

            if (is_null($attribute)) {
                return null;
            }

            if (! $attribute instanceof Carbon) {
                throw new MacroAttributeException(
                    sprintf('The attribute `%s` is not a Carbon instance', $attribute)
                );
            }

            $now = Carbon::now();
            $attribute->setYear($now->year);

            if ($attribute->year < $now->year) {
                $attribute->addYear();
            }

            return $now->diffInYears($attribute);
        };
    }
}
