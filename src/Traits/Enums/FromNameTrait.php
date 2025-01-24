<?php

namespace NormanHuth\Library\Traits\Enums;

use Exception;
use Illuminate\Support\Str;
use Throwable;

trait FromNameTrait
{
    /**
     * Return the corresponding Enum Case.
     */
    public static function fromName(string $name): self
    {
        $name = Str::upper(Str::slug($name, '_'));

        return constant('self::' . $name);
    }

    /**
     * Return the corresponding Enum Case.
     */
    public static function tryFromName(string $name): self
    {
        try {
            return self::fromName($name);
        } catch (Exception | Throwable) {
            return self::getDefault();
        }
    }
}
