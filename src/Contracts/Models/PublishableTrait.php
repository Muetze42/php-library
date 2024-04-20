<?php

namespace NormanHuth\Library\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */

trait PublishableTrait
{
    /**
     * Initialize the trait.
     */
    protected function initializePublishableTrait(): void
    {
        $this->mergeFillable(['published_at', 'published_until']);
        $this->mergeCasts([
            'published_at' => 'datetime',
            'published_until' => 'datetime',
        ]);
    }

    /**
     * Scope a query to only include published resources.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', now())
            ->where(function (Builder $query) {
                $query->whereNull('published_until')
                    ->orWhere('published_until', '>=', now());
            });
    }

    /**
     * Scope a query to only include not published resources.
     */
    public function scopeUnpublished(Builder $query): void
    {
        $query->where(function (Builder $query) {
            $query->where('published_until', '<=', now())
                ->orWhere(function (Builder $query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '>=', now());
                });
        });
    }

    /**
     * Check if the resource is published.
     */
    public function isPublished(): bool
    {
        return $this->published_at <= now() && (is_null($this->published_until) || $this->published_until >= now());
    }

    /**
     * Check if the resource is not published.
     */
    public function isUnpublished(): bool
    {
        return ! $this->isPublished();
    }

    /**
     * Publish the resource.
     */
    public function publish(?Carbon $publishAt = null, ?Carbon $publishUntil = null): bool
    {
        return $this->update([
            'published_at' => $publishAt ?? now(),
            'published_until' => $publishUntil,
        ]);
    }

    /**
     * Unpublish the resource.
     */
    public function unpublish(?Carbon $publishUntil = null): bool
    {
        return $this->update(['published_until' => $publishUntil ?? now()]);
    }
}
