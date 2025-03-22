<?php

namespace NormanHuth\Library\Packages\Sanctum\Refreshable\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class TokenMustFreshException extends AuthorizationException
{
    /**
     * Create a new authorization exception instance.
     */
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Token must be refreshed.', $code, $previous);
    }
}
