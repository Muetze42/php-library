<?php

namespace NormanHuth\Library\Exceptions;

use InvalidArgumentException;

class CastException extends InvalidArgumentException
{
    /**
     * Construct the exception.
     */
    public function __construct(string $type)
    {
        parent::__construct(sprintf('The given value could not be cast to %s.', $type));
    }
}
