<?php

namespace NormanHuth\Library\Support\Macros\Collection;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @mixin \Illuminate\Support\Collection
 *
 * This class is derived from the code of the spatie/laravel-collection-macros package
 *
 * @see https://github.com/spatie/laravel-collection-macros
 */
class PaginateMacro
{
    public function __invoke(): Closure
    {
        /**
         * Paginate the given collection.
         */
        return function (
            int $perPage = 15,
            string $pageName = 'page',
            ?int $currentPage = null,
            array $options = []
        ): LengthAwarePaginator {
            $currentPage = $currentPage ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            $results = $this->forPage($currentPage, $perPage)->values();

            $options += [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];

            return new LengthAwarePaginator($results, $this->count(), $perPage, $currentPage, $options);
        };
    }
}
