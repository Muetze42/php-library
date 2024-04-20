<?php

namespace NormanHuth\Library\Contracts\Nova\Resources;

use Illuminate\Support\Str;

trait ProperNounLabelsTrait
{
    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return Str::title(Str::snake(class_basename(get_called_class()), ' '));
    }

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return static::singularLabel();
    }
}
