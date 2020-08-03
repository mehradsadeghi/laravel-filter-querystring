<?php

namespace Mehradsadeghi\FilterQueryString;

trait Resolvings {

    private function resolve($query, $filterName, $values) {

        if($this->customDefinedFilter($filterName)) {
            return $this->resolveCustomFilter($query, $filterName, $values);
        }

        $availableFilter = $this->availableFilters[$filterName] ?? $this->availableFilters['default'];

        return app($availableFilter, ['filter' => $filterName, 'values' => $values]);
    }

    private function makeAsbtractName($filter) {
        return static::class.'@'.$filter;
    }

    private function makeCallable($abstract, $query, $values) {
        app()->bind($abstract, function () use ($abstract, $query, $values) {
            return function ($query, $next) use ($abstract, $values) {
                return app()->call($abstract, [$next($query), $values]);
            };
        });
    }

    private function customDefinedFilter($filterName) {
        return method_exists($this, $filterName);
    }

    private function resolveCustomFilter($query, $filterName, $values) {
        $abstract = $this->makeAsbtractName($filterName);
        $this->makeCallable($abstract, $query, $values);
        return $abstract;
    }
}
