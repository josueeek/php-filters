<?php

namespace Josueeek\Filters\Traits;

use Josueeek\Filters\BaseFilters;

trait FilterableTrait
{
    /**
     * Applies filters to the scoped query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Josueeek\Filters\BaseFilters $filters
     * @param array $extraFilters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, BaseFilters $filters, array $extraFilters = null)
    {
        return $filters->apply($query, $extraFilters);
    }
}
