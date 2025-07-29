<?php

namespace NormanHuth\Library\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

/**
 * Validation rule for common text input, enforcing specific character patterns.
 */
class CommonInputTextRule implements ValidationRule
{
    use ValidatesAttributes;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->validateRegex($attribute, $value, ['/^[\p{L}\p{N} .,’\'\-]+$/u'])) {
            $fail('validation.regex')->translate();
        }
    }
}
