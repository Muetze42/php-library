<?php

namespace NormanHuth\Library\Traits;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use NormanHuth\Library\Exceptions\MissingAttributeException;

/**
 * This trait is derived from the code of the Laravel™ Framework (2024-08-24), wich is subject of
 * the MIT License (https://github.com/laravel/framework?tab=MIT-1-ov-file#readme)
 * Copyright (c) 2011-2024 Laravel Holdings Inc. (https://laravel.com/)
 */
trait HasAttributesCastingTrait
{
    use HasAttributes;

    /**
     * The object's attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, mixed>
     */
    protected $casts = [];

    /**
     * Indicates that an error should be thrown if you want to access a non-existent attribute.
     */
    protected bool $throwMissingAttributeException = true;

    /**
     * Determine that an error should be thrown if you want to access a non-existent attribute.
     *
     * @return $this
     */
    public function throwMissingAttributeException(bool $state): static
    {
        $this->throwMissingAttributeException = $state;

        return $this;
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute(string $key): mixed
    {
        if ($this->throwMissingAttributeException && ! array_key_exists($key, $this->attributes)) {
            throw new MissingAttributeException($this, $key);
        }

        return data_get($this->attributes, $key);
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

            $this->attributes[$key] = $this->castAttribute($key, $this->attributes[$key]);
        });
    }
}
