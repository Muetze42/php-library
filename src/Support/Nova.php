<?php

namespace NormanHuth\Library\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Nova\Resource;

class Nova
{
    /**
     * Generate a Nova resource url.
     */
    public function resourceUrl(string|Model|Resource $resource): string
    {
        $path = [
            trim(config('nova.path'), '/'),
            'resources',
            Str::plural(Str::kebab(class_basename(class_basename($resource)))),
        ];

        if ($resource instanceof Model) {
            $path[] = $resource->getKey();
        } elseif ($resource instanceof Resource) {
            $path[] = $resource->model()->getKey();
        }

        return url(implode('/', $path));
    }

    /**
     * Decode the filter string from base64 encoding.
     */
    public static function decodeFilter(string $filtersRequestString): array
    {
        if (empty($filtersRequestString)) {
            return [];
        }

        $filters = json_decode(base64_decode($filtersRequestString), true);

        return is_array($filters) ? $filters : [];
    }

    /**
     * Check if a Nova (4) filter is active.
     */
    public static function isFilterActive($filter): bool
    {
        $filtersRequest = request()->input('filters');

        if (! $filtersRequest) {
            return false;
        }

        $filters = static::decodeFilter($filtersRequest);

        $check = array_filter(array_values($filters), function ($value) use ($filter) {
            return isset($value[$filter]) && $value[$filter] != '';
        });

        return ! empty($check);
    }
}
