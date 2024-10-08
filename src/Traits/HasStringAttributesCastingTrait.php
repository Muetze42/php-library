<?php

namespace NormanHuth\Library\Traits;

use Illuminate\Support\Carbon;

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

        $value = $this->castAttribute($key, $value);

        if ($value instanceof Carbon && $timezone = config('app.timezone')) {
            $value->tz($timezone);
        }

        return $value;
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
