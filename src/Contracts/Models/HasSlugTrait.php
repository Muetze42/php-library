<?php

namespace NormanHuth\Library\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Query\Builder
 */
trait HasSlugTrait
{
    /**
     * The sluggable attributes.
     */
    public array $sluggable = ['title', 'name'];

    /**
     * Initialize the trait.
     */
    public function initializeHasSlugTrait(): void
    {
        $this->mergeFillable(['batch']);
    }

    public static function bootHasSlugTrait()
    {
        static::saving(function (Model $model) {
            foreach ((new static())->sluggable as $attribute) {
                if (in_array($attribute, (new static())->getFillable()) || !is_null($model->{$attribute})) {
                    $model->slug = Str::slug($model->{$attribute});
                }
            }
        });
    }
}
