<?php

namespace NormanHuth\Library\Traits;

trait HasStringAttributesCastingTrait
{
    use HasAttributesCastingTrait;

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castStringAttribute(string $key, mixed $value): mixed
    {
        $castType = $this->getCastType($key);

        if (in_array($castType, ['bool', 'boolean'])) {
            return is_bool($value) ? $value : $value == 'true';
        }

        return $this->castAttribute($key, $value);
    }

    /**
     * Cast an attribute to a native PHP type.
     */
    protected function castAttributes(): void
    {
        collect($this->casts)->each(function (mixed $value, string $key) {
            if (! isset($this->attributes[$key])) {
                return;
            }

            $this->attributes[$key] = $this->castStringAttribute($key, $this->attributes[$key]);
        });
    }
}
