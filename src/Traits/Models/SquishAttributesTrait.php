<?php

namespace NormanHuth\Library\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Provides functionality to automatically "squish" specific attributes during the model's lifecycle.
 * The squishing process removes excess whitespace from specified string attributes
 * to ensure consistency and standard formatting in the stored data.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Query\Builder
 */
trait SquishAttributesTrait
{
    /**
     * The attributes that are mass should squish.
     *
     * @var string[]
     */
    protected array $squishAttributes = [
        'city',
        'company',
        'country',
        'department',
        'first_name',
        'firstname',
        'full_name',
        'headline',
        'house_number',
        'industry',
        'label',
        'last_name',
        'lastname',
        'name',
        'note',
        'phone',
        'position',
        'postal_code',
        'salutation',
        'state',
        'street',
        'street_name',
        'street_number',
        'title',
        'zip',
    ];

    /**
     * Additional attributes that are mass should squish.
     *
     * @var string[]
     */
    protected array $additionalSquishAttributes = [];

    /**
     * Bootstrap the trait.
     */
    public static function bootHasSlugTrait(): void
    {
        static::saving(function (Model $model) {
            $attributes = array_merge($this->squishAttributes, $this->additionalSquishAttributes);
            foreach ($attributes as $attribute) {
                if (! empty($model->{$attribute}) && is_string($model->{$attribute})) {
                    $model->{$attribute} = Str::squish($model->{$attribute});
                }
            }
        });
    }
}
