<?php

namespace Mehradsadeghi\FilterQueryString;

use Illuminate\Pipeline\Pipeline;
use Mehradsadeghi\FilterQueryString\Filters\{OrderbyClause, WhereClause, WhereInClause, WhereLikeClause};
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\{GreaterOrEqualTo, GreaterThan, LessOrEqualTo, LessThan};
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between\{Between, NotBetween};

trait FilterQueryString {
    use Resolvings;

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

    public function scopeFilter($query,...$filters)
    {
        $filters = collect($this->getFilters($filters))
            ->filter(function ($value,$key){
                return !property_exists($this, "searchable") || $this->isColumnSearchable($value, $key);
            })
            ->map(function ($values, $filter) {
                return $this->resolve($filter, $values);
        })
            ->toArray();
        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }

    private function getFilters($filters)
    {
        $filter = function ($key) use($filters) {
            $filters = $filters ?: $this->filters ?: [];

            return $this->unguardFilters != true ? in_array($key, $filters) : true;
        };
        return array_filter(request()->query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }
    public function isColumnSearchable($values,$key):bool {
        [$column]=explode(",",$values);
        return in_array($column,$this->searchable);
    }
}
