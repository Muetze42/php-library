<?php

namespace NormanHuth\Library\Contracts\Models;

use ReflectionClass;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait GetRelationsTrait
{
    /**
     * Get all the relations for the model.
     */
    public static function getRelationsToArray(): array
    {
        $reflector = new ReflectionClass(get_called_class());

        return collect($reflector->getMethods())
            ->filter(
                fn ($method) => ! empty($method->getReturnType()) &&
                    str_contains(
                        $method->getReturnType(),
                        'Illuminate\Database\Eloquent\Relations'
                    )
            )
            ->pluck('name')
            ->all();
    }
}
