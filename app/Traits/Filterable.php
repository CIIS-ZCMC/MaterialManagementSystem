<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    /**
     * Scope a query to apply dynamic filters.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $query
     * @param  array<string, mixed>|Request  $filters
     * @return Builder<TModel>
     */
    public function scopeFilter(Builder $query, array|Request $filters): Builder
    {
        $filterData = $filters instanceof Request ? $filters->all() : $filters;

        foreach ($filterData as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $method = 'filterBy'.str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
            }
        }

        return $query;
    }
}
