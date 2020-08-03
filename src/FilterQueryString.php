<?php

namespace Mehradsadeghi\FilterQueryString;

use Illuminate\Pipeline\Pipeline;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between\{Between, NotBetween};
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\{GreaterOrEqualTo, GreaterThan, LessOrEqualTo, LessThan};
use Mehradsadeghi\FilterQueryString\Filters\{BaseClause,
    Blank,
    OrderbyClause,
    WhereClause,
    WhereInClause,
    WhereLikeClause};

trait FilterQueryString {

    private $availableFilters = [
        'default' => WhereClause::class,
        'sort' => OrderbyClause::class,
        'greater' => GreaterThan::class,
        'greater_or_equal' => GreaterOrEqualTo::class,
        'less' => LessThan::class,
        'less_or_equal' => LessOrEqualTo::class,
        'between' => Between::class,
        'not_between' => NotBetween::class,
        'in' => WhereInClause::class,
        'like' => WhereLikeClause::class,
    ];

    public function scopeFilter($query)
    {
        $filters = collect($this->getFilters())->map(function($values, $filter) use ($query) {
            return $this->resolve($query, $filter, $values);
        })->toArray();

        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();

        // todo user custom functions
    }

    private function getFilters()
    {
        $filter = function ($key) {
            return $this->unguardFilters != true ? in_array($key, $this->filters ?? []) : true;
        };

        return array_filter(request()->query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }

    private function resolve($query, $filter, $values) {

        if(method_exists($this, $filter)) {
            $abstract = $this->makeAsbtract($filter);
            $this->makeCallable($abstract, $query, $values);
            return $abstract;
        }

        if(!empty($this->availableFilters[$filter])) {
            return app($this->availableFilters[$filter], [
                'filter' => $filter,
                'values' => $values,
            ]);
        }

        return app($this->availableFilters['default'], [
            'filter' => $filter,
            'values' => $values,
        ]);
    }

    private function makeAsbtract($filter) {
        return static::class.'@'.$filter;
    }

    private function makeCallable($abstract, $query, $values) {
        app()->bind($abstract, function () use ($abstract, $query, $values) {
            return function ($query, $next) use ($abstract, $values) {
                return app()->call($abstract, [$next($query), $values]);
            };
        });
    }
}
