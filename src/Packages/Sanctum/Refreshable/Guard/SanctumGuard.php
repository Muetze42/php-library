<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable\Guard;

use Laravel\Sanctum\Guard;
use NormanHuth\Library\Packages\Sanctum\Refreshable\Exceptions\TokenMustFreshException;

class SanctumGuard extends Guard
{
    /**
     * Determine if the provided access token is valid.
     *
     * @param  mixed  $accessToken
     */
    public function isValidAccessToken($accessToken): bool
    {
        if (! parent::isValidAccessToken($accessToken)) {
            return false;
        }

        if ($accessToken->invalid_at && $accessToken->invalid_at->isPast()) {
            $this->throwTokenMustFreshException();
        }

        return true;
    }

    /**
     * Throw an exception if the token is not expired, but must be refreshed.
     */
    protected function throwTokenMustFreshException(): void
    {
        throw new TokenMustFreshException();
    }
}
