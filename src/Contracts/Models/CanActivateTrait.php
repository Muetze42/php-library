<?php

namespace NormanHuth\Library\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait CanActivateTrait
{
    /**
     * The active attribute column name.
     */
    protected static string $activeAttributeColum = 'active';

    /**
     * Initialize the trait.
     */
    protected function initializeCanActivateTrait(): void
    {
        $this->mergeFillable([static::$activeAttributeColum]);
        $this->mergeCasts([static::$activeAttributeColum => 'bool']);
    }

    /**
     * Scope a query to only include active resources.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where(static::$activeAttributeColum, true);
    }

    /**
     * Scope a query to only include not active resources.
     */
    public function scopeDeactivated(Builder $query): void
    {
        $query->where(static::$activeAttributeColum, false);
    }

    /**
     * Check if the resource is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Check if the resource is not active.
     */
    public function isDeactivated(): bool
    {
        return ! $this->isActive();
    }

    /**
     * Activate the resource.
     */
    public function activate(): bool
    {
        if ($this->active) {
            return false;
        }

        return $this->update(['active' => true]);
    }

    /**
     * Deactivate the resource.
     */
    public function deactivate(): bool
    {
        if (! $this->active) {
            return false;
        }

        return $this->update(['active' => false]);
    }
}
