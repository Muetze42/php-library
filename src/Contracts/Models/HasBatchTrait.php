<?php

namespace NormanHuth\Library\Contracts\Models;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Query\Builder
 */
trait HasBatchTrait
{
    /**
     * Initialize the trait.
     */
    public function initializeHasBatchTrait(): void
    {
        $this->mergeCasts(['batch' => 'int']);
        $this->mergeFillable(['batch']);
    }

    /**
     * Get the latest batch integer.
     */
    public static function getLatestBatch(): ?int
    {
        return static::max('batch');
    }

    /**
     * Get the next batch integer.
     */
    public static function getNextBatch(): int
    {
        return ((int) static::getLatestBatch()) + 1;
    }
}
