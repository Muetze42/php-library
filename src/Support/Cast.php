<?php

namespace NormanHuth\Library\Support;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable as IlluminateStringable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use NormanHuth\Library\Exceptions\CastException;
use Stringable;
use Throwable;

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

        if (is_string($value) || is_null($value)) {
            return (string) $value;
        }

        if ($value instanceof Jsonable || is_object($value) && method_exists($value, 'toJson')) {
            return (new self($value->toJson()))->toString($separator);
        }

        if ($value instanceof IlluminateStringable || is_object($value) && method_exists($value, 'toString')) {
            return (new self($value->toString()))->toString($separator);
        }

        if ($value instanceof JsonSerializable) {
            return (new self($value->jsonSerialize()))->toString($separator);
        }

        if ($value instanceof Arrayable || is_object($value) && method_exists($value, 'toArray')) {
            try {
                $value = (new self($value->toArray()))->toArray();
            } catch (Exception | Throwable) {
                throw new CastException('string');
            }

            return implode($separator, $value);
        }

        if ($value instanceof Stringable || is_object($value) && method_exists($value, '__toString')) {
            try {
                $value = (new self($value->__toString()))->toString();
            } catch (Exception | Throwable) {
                throw new CastException('string');
            }
        }

        if (is_object($value)) {
            $value = serialize($value);
        }

        if (! is_string($value)) {
            throw new CastException('string');
        }

        return $value;
    }

    /**
     * Try to get the value as array.
     *
     * @return array
     *
     * @throws\NormanHuth\Library\Exceptions\CastException
     */
    public function toArray(): array
    {
        $value = $this->value;

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            if (Str::isJson($value)) {
                $value = json_decode($value, true);

                if (! is_array($value)) {
                    throw new CastException('array');
                }
            }

            if (is_string($value)) {
                return (new self(preg_split('/\r\n|\n|\r/', $value)))->toArray();
            }
        }

        if ($value instanceof Arrayable || is_object($value) && method_exists($value, 'toArray')) {
            return (new self($value->toArray()))->toArray();
        }

        if ($value instanceof Jsonable || is_object($value) && method_exists($value, 'toJson')) {
            return (new self($value->toJson()))->toArray();
        }

        if (! is_array($value)) {
            throw new CastException('array');
        }

        return $value;
    }
}
