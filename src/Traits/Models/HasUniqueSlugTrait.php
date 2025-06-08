<?php

namespace NormanHuth\Library\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Query\Builder
 */
trait HasUniqueSlugTrait
{
    /**
     * The sluggable attributes.
     */
    public array $sluggable = ['title', 'name'];

    /**
     * Bootstrap the trait.
     */
    public static function bootHasUniqueSlugTrait(): void
    {
        static::saving(function (Model $model) {
            foreach ((new static())->sluggable as $attribute) {
                if (in_array($attribute, (new static())->getFillable()) || ! is_null($model->{$attribute})) {
                    $baseSlug = Str::slug($model->{$attribute});
                    $slug = $baseSlug;
                    $i = 1;

                    while (
                    static::where('slug', $slug)
                        ->when($model->exists, fn ($q) => $q->whereKeyNot($model->getKey()))
                        ->exists()
                    ) {
                        $slug = $baseSlug . '-' . $i++;
                    }

                    $model->slug = $slug;
                }
            }
        });
    }
}
