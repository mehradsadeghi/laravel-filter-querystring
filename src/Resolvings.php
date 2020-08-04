<?php

namespace Mehradsadeghi\FilterQueryString;

trait Resolvings {

    private function resolve($query, $filterName, $values) {

        if($this->isCustomFilter($filterName)) {
            return $this->resolveCustomFilter($query, $filterName, $values);
        }

        $availableFilter = $this->availableFilters[$filterName] ?? $this->availableFilters['default'];

        return app($availableFilter, ['filter' => $filterName, 'values' => $values]);
    }

    private function resolveCustomFilter($query, $filterName, $values) {
        $abstract = $this->makeAsbtractName($filterName);
        $this->bindToContainer($abstract, $query, $values);
        return $abstract;
    }

    private function makeAsbtractName($filter) {
        return static::class.'@'.$filter;
    }

    private function bindToContainer($abstract, $query, $values) {
        app()->bind($abstract, function () use ($abstract, $query, $values) {
            return $this->getClosure($abstract, $values);
        });
    }

    private function isCustomFilter($filterName) {
        return method_exists($this, $filterName);
    }

    private function getClosure($abstract, $values){
        return function ($query, $next) use ($abstract, $values) {
            return app()->call($abstract, [$next($query), $values]);
        };
    }
}
