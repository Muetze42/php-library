<?php

namespace NormanHuth\Library\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Stringable as IlluminateStringable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use NormanHuth\Library\Exceptions\CastException;
use Stringable;

class Cast
{
    use Macroable;

    /**
     * The value to cast.
     */
    public mixed $value;

    /**
     * Instantiate a new Cast instance.
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * Try to get the value as underlying string.
     *
     * @param  string  $separator  The separator to use when concatenating the string
     * @return string
     *
     * @throws \NormanHuth\Library\Exceptions\CastException
     */
    public function toString(string $separator = ' '): string
    {
        $value = $this->value;

        if (is_null($value)) {
            return '';
        }
        if ($value instanceof Jsonable || is_object($value) && method_exists($value, 'toJson')) {
            return $value->toJson();
        }
        if ($value instanceof IlluminateStringable || is_object($value) && method_exists($value, 'toString')) {
            return $value->toString();
        }
        if ($value instanceof JsonSerializable) {
            return (new self($value->jsonSerialize()))->toString($separator);
        }
        if ($value instanceof Arrayable || is_object($value) && method_exists($value, 'toArray')) {
            $value = $value->toArray();
        }
        if (is_array($value)) {
            return implode($separator, $value);
        }
        if ($value instanceof Stringable || is_object($value) && method_exists($value, '__toString')) {
            return $value->__toString();
        }
        if (is_object($value)) {
            return serialize($value);
        }

        if (! is_string($value)) {
            throw new CastException('string');
        }

        return $value;
    }
}
