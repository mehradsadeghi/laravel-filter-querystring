<?php

namespace Mehradsadeghi\FilterQueryString;

use Illuminate\Support\Facades\Request;
use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClause;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\GreaterOrEqualTo;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\GreaterThan;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\LessOrEqualTo;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\LessThan;
use Mehradsadeghi\FilterQueryString\Filters\OrderbyClause;
use Mehradsadeghi\FilterQueryString\Filters\WhereClause;

trait FilterQueryString {

    private $filterings = [
        'default' => WhereClause::class,
        'sort' => OrderbyClause::class,
        'greater' => GreaterThan::class,
        'greater_or_equal' => GreaterOrEqualTo::class,
        'less' => LessThan::class,
        'less_or_equal' => LessOrEqualTo::class,
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->unguardFilters = $this->unguardFilters ?? false;
    }

    public function scopeFilter($query)
    {
        dd($this->getFilters());
        foreach($this->getFilters() as $filter => $values) {

            $params = [
                'query' => $query,
                'filter' => $filter,
                'values' => $values,
            ];

            $targetFilter = !empty($this->filterings[$filter]) ? $filter : 'default';

            try {

                app($this->filterings[$targetFilter], $params)->apply();

            } catch (InvalidArgumentException $exception) {
                continue;
            }
        }

        return $query;
    }

    private function getFilters()
    {
        $filter = function ($key) {
            return !$this->unguardFilters ? in_array($key, $this->filters) : true;
        };

        return array_filter(Request::query(), $filter, ARRAY_FILTER_USE_BOTH) ?? [];
    }
}
