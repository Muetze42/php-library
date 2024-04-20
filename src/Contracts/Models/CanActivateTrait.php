<?php

namespace NormanHuth\Library\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait CanActivateTrait
{
    /**
     * Initialize the trait.
     */
    protected function initializeCanActivateTrait(): void
    {
        $this->mergeFillable(['active']);
        $this->mergeCasts(['active' => 'bool']);
    }

    /**
     * Scope a query to only include active resources.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }
}
