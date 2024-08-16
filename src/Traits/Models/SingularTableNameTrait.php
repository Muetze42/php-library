<?php

namespace NormanHuth\Library\Traits\Models;

use Illuminate\Support\Str;

trait SingularTableNameTrait
{
    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return $this->table ?? Str::snake(class_basename($this));
    }
}
