<?php

namespace NormanHuth\Library\Support\Macros\Collection;

use Closure;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\Paginator;

/**
 * @mixin \Illuminate\Support\Collection
 *
 * This class is derived from the code of the spatie/laravel-collection-macros package
 *
 * @see https://github.com/spatie/laravel-collection-macros
 */
class SimplePaginateMacro
{
    public function __invoke(): Closure
    {
        /**
         * Paginate the given collection into a simple paginator.
         */
        return function (
            int $perPage = 15,
            string $pageName = 'page',
            ?int $currentPage = null,
            array $options = []
        ): PaginatorContract {
            $currentPage = $currentPage ?: Paginator::resolveCurrentPage($pageName);

            $results = $this->slice(($currentPage - 1) * $perPage)->take($perPage + 1);

            $options += [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];

            return new Paginator($results, $perPage, $perPage, $options);
        };
    }
}
