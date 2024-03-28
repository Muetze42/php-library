<?php

namespace NormanHuth\Library\Macros\Http\Response;

use Closure;

/**
 * @mixin \Illuminate\Http\Client\Response
 */
class Message
{
    /**
     * Try to get the JSON decoded body of the response as an array or scalar value.
     */
    public function __invoke(): Closure
    {
        return function (string $key = 'message'): string {
            $message = $this->json($key);

            return empty($message) || is_array($message) ? $this->body() : $message;
        };
    }
}
