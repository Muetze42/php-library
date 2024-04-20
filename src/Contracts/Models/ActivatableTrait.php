<?php

namespace NormanHuth\Library\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait ActivatableTrait
{
    /**
     * Initialize the trait.
     */
    protected function initializeActivatableTrait(): void
    {
        $this->mergeFillable(['activated_at', 'activated_until']);
        $this->mergeCasts([
            'activated_at' => 'datetime',
            'activated_until' => 'datetime',
        ]);
    }

    /**
     * Scope a query to only include active resources.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('activated_at', '<=', now())
            ->where(function (Builder $query) {
                $query->whereNull('activated_until')
                    ->orWhere('activated_until', '>=', now());
            });
    }

    /**
     * Scope a query to only include not active resources.
     */
    public function scopeDeactivated(Builder $query): void
    {
        $query->where(function (Builder $query) {
            $query->where('activated_until', '<=', now())
                ->orWhere(function (Builder $query) {
                    $query->whereNull('activated_at')
                        ->orWhere('activated_at', '>=', now());
                });
        });
    }

    /**
     * Check if the resource is active.
     */
    public function isActive(): bool
    {
        return $this->activated_at <= now() && (is_null($this->activated_until) || $this->activated_until >= now());
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
    public function activate(?Carbon $activateAt = null, ?Carbon $activateUntil = null): bool
    {
        return $this->update([
            'activated_at' => $activateAt ?? now(),
            'activated_until' => $activateUntil,
        ]);
    }

    /**
     * Deactivate the resource.
     */
    public function deactivate(?Carbon $activateUntil = null): bool
    {
        return $this->update(['activated_until' => $activateUntil ?? now()]);
    }
}
