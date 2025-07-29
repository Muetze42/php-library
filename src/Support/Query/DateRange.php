<?php

namespace NormanHuth\Library\Support\Query;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Provides methods to filter a query by specific date ranges including days, months, quarters, and years.
 */
class DateRange
{
    /**
     * Filters the query to include records where the given date column falls within the current year.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to consider for the date comparison. Defaults to null.
     */
    public function currentYear(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfYear(),
            CarbonImmutable::now($timezone)->endOfYear(),
        ]);
    }

    /**
     * Filters the query to include records where the given date column falls within the last year.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to consider for the date comparison. Defaults to null.
     */
    public function lastYear(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->subYear()->startOfYear(),
            CarbonImmutable::now($timezone)->subYear()->endOfYear(),
        ]);
    }

    /**
     * Filters the query to include records where the given date column falls within the next year.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to consider for the date comparison. Defaults to null.
     */
    public function nextYear(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->addYear()->startOfYear(),
            CarbonImmutable::now($timezone)->addYear()->endOfYear(),
        ]);
    }

    /**
     * Filters the query to include records where the given date column falls within the current day.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to consider for the date comparison. Defaults to null.
     */
    public function today(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfDay(),
            CarbonImmutable::now($timezone)->endOfDay(),
        ]);
    }

    /**
     * Filters the query to include records where the given date column falls within yesterday.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to consider for the date comparison. Defaults to null.
     */
    public function yesterday(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->subDay()->startOfDay(),
            CarbonImmutable::now($timezone)->subDay()->endOfDay(),
        ]);
    }

    /**
     * Filters the query to include records where the specified column's value
     * falls within the current month, based on the provided timezone.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to determine the current month.
     */
    public function currenMonth(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfMonth(),
            CarbonImmutable::now($timezone)->endOfMonth(),
        ]);
    }

    /**
     * Filters the query to include records where the specified column's value
     * falls within the previous month, based on the provided timezone.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to determine the previous month.
     */
    public function lastMonth(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->subMonth()->startOfMonth(),
            CarbonImmutable::now($timezone)->subMonth()->endOfMonth(),
        ]);
    }

    /**
     * Filters the query to include records where the specified column's value
     * falls within the current week, based on the provided timezone.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to determine the current week.
     */
    public function thisWeek(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfWeek(),
            CarbonImmutable::now($timezone)->endOfWeek(),
        ]);
    }

    /**
     * Filters the query to include records where the specified column's value
     * falls within the month to date (MTD) range, based on the provided timezone.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  string  $column  The name of the column to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  An optional timezone to determine the current date and the start of the month.
     */
    public function mtd(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfMonth(),
            CarbonImmutable::now($timezone),
        ]);
    }

    /**
     * Filters the provided query to include records where the specified column's value
     * falls within the current quarter, starting from the beginning of the quarter
     * up to the current moment.
     *
     * @param  Builder  $query  The query builder instance to modify.
     * @param  string  $column  The column name to filter by. Defaults to 'created_at'.
     * @param  string|null  $timezone  The timezone to use for determining the quarter boundaries.
     *                                 Defaults to null, which uses the application's default timezone.
     */
    public function qtd(Builder $query, string $column = 'created_at', ?string $timezone = null): Builder
    {
        return $query->whereBetween($column, [
            CarbonImmutable::now($timezone)->startOfQuarter(),
            CarbonImmutable::now($timezone),
        ]);
    }
}
