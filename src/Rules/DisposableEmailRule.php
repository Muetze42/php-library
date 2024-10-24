<?php

namespace NormanHuth\Library\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DisposableEmailRule implements ValidationRule
{
    protected string $translationKey = 'validation.custom.disposable_email';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $path = 'disposable-email-domains.json';

        if (Storage::missing($path)) {
            Artisan::call('app:update-disposable-email-domains');
        }

        if (Storage::exists($path)) {
            $domains = Storage::json($path);
            if (! is_string($value)) {
                $fail($this->translationKey)->translate(['attribute' => $value]);
                return;
            }
            $value = Str::lower(trim($value));
            $parts = explode('@', $value);
            if (empty($parts[1]) || in_array($parts[1], (array) $domains)) {
                $fail($this->translationKey)->translate(['attribute' => $value]);
            }
        }
    }
}
