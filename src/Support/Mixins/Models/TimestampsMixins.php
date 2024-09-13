<?php

namespace NormanHuth\Library\Support\Mixins\Models;

use Illuminate\Support\Carbon;
use NormanHuth\Library\Exceptions\MacroAttributeException;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @psalm-suppress UndefinedMethod
 * @psalm-suppress UndefinedThisPropertyFetch
 * @psalm-suppress UndefinedThisPropertyAssignment
 */
class TimestampsMixins
{
    /**
     * Resolve the attribute for the timestamps ago mixin.
     *
     * @param  string  $attribute
     * @return string|null
     */
    protected function resolveAttributeForTimestampsAgoMixin(string $attribute): ?string
    {
        $value = $this->{$attribute};

        if (is_null($value)) {
            return null;
        }

        if (! $value instanceof Carbon) {
            throw new MacroAttributeException(
                sprintf('The attribute `%s` is not a Carbon instance', $attribute)
            );
        }

        return Carbon::now()->diffForHumans($attribute);
    }

    /**
     * Get the age of the `created_at` attribute.
     */
    public function createdAgo(string $attribute = 'created_at'): ?string
    {
        return $this->resolveAttributeForTimestampsAgoMixin($attribute);
    }

    /**
     * Get the age of the `updated_at` attribute.
     */
    public function updatedAgo(string $attribute = 'updated_at'): ?string
    {
        return $this->resolveAttributeForTimestampsAgoMixin($attribute);
    }

    /**
     * Get the age of the `deleted_at` attribute.
     */
    public function deletedAgo(string $attribute = 'deleted_at'): ?string
    {
        return $this->resolveAttributeForTimestampsAgoMixin($attribute);
    }
}
