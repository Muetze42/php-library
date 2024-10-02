<?php

namespace NormanHuth\Library\Traits;

trait HasPrimaryKeyTrait
{
    /**
     * The primary key for the model.
     */
    //protected string $primaryKey = null;

    /**
     * The "type" of the primary key ID.
     */
    //protected string $keyType = 'int';

    /**
     * Get the primary key for the model.
     *
     * @return string|null
     */
    public function getKeyName(): ?string
    {
        return $this->primaryKey;
    }

    /**
     * Set the primary key for the model.
     *
     * @param  string|null  $key
     * @return $this
     */
    public function setKeyName(?string $key): static
    {
        $this->primaryKey = $key;

        return $this;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return $this->keyType;
    }

    /**
     * Set the data type for the primary key.
     *
     * @param  string  $type
     * @return $this
     */
    public function setKeyType(string $type): static
    {
        $this->keyType = $type;

        return $this;
    }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey(): mixed
    {
        return $this->getAttribute($this->getKeyName());
    }
}
