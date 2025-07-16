<?php

namespace NormanHuth\Library\Traits;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait EnsureIsNotRateLimitedTrait
{
    /**
     * Specify the max attempts until Lockout.
     */
    protected int $maxAttempts = 5;

    /**
     * The validation key using for validation exception.
     */
    protected function validationKey(): string
    {
        return 'email';
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts)) {
            return;
        }

        $this->dispatchLockoutEvent();

        $this->throwLockoutException();
    }

    /**
     * Throw a Lockout exception if the given key has been 'accessed' too many times.
     */
    protected function throwLockoutException(): void
    {
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            $this->validationKey() => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Clear the hits and lockout time for the given limiter.
     */
    protected function clearLimiter(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Dispatch a Lockout event and call the listeners.
     */
    protected function dispatchLockoutEvent(): void
    {
        event(new Lockout(request()));
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower(request()->ip()));
    }

    /**
     * Increment (by 1) the counter for a given throttle key.
     */
    protected function incrementRateLimiterCounter(): void
    {
        RateLimiter::hit($this->throttleKey());
    }

    /**
     * Example: Handle an incoming authentication request.
     */
    // public function login(): void
    // {
    //     $this->validate();
    //
    //     $this->ensureIsNotRateLimited();
    //
    //     if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
    //         $this->incrementRateLimiterCounter();
    //
    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }
    //
    //     $this->clearLimiter();
    //     Session::regenerate();
    //
    //     $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    // }
}
