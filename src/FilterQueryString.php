<?php

namespace Mehradsadeghi\FilterQueryString;

use Closure;
use Illuminate\Support\Facades\Request;
use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClause;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between\NotBetween;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\GreaterOrEqualTo;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between\Between;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\GreaterThan;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\LessOrEqualTo;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\LessThan;
use Mehradsadeghi\FilterQueryString\Filters\OrderbyClause;
use Mehradsadeghi\FilterQueryString\Filters\WhereClause;
use Mehradsadeghi\FilterQueryString\Filters\WhereInClause;
use Mehradsadeghi\FilterQueryString\Filters\WhereLikeClause;

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
        foreach($this->getFilters() as $filter => $values) {

            $resolvedFilter = $this->resolveFilter($filter);

            try {

                // if resolved filter is a user custom defined filter
                if($resolvedFilter instanceof Closure) {
                    $resolvedFilter($query, $values);
                    continue;
                }

                app()->resolving($resolvedFilter, function($object) use($values) {
                    $object->validate($values);
                });

                $params = [
                    'query' => $query,
                    'filter' => $filter,
                    'values' => $values,
                ];

                app($resolvedFilter, $params)->apply();

            } catch (InvalidArgumentException $exception) {
                continue;
            }
        }

        return $query;
    }

    private function getFilters()
    {
        $filter = function ($key) {
            return $this->unguardFilters != true ? in_array($key, $this->filters) : true;
        };

        return array_filter(Request::query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }

    private function resolveFilter($filter) {

        if(method_exists($this, $filter)) {
            return $this->getClosure($filter);
        }

        if(!empty($this->availableFilters[$filter])) {
            return $this->availableFilters[$filter];
        }

        return $this->availableFilters['default'];
    }

    private function getClosure(string $filter) {
        return function ($query, $values) use ($filter) {
            return $this->{$filter}($query, $values);
        };
    }
}
