<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Illuminate\Database\Eloquent\Builder;
use Mehradsadeghi\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    protected $isDateTime = false;
    protected $method;
    protected $normalized = [];

    public function apply($query): Builder
    {
        $this->normalizeValues($this->values);

        foreach ($this->normalized as $field => $value) {
            $query->{$this->determineMethod($value)}($field, $this->operator, $value);
        }

        return $query;
    }

    public function validate($value): bool
    {
        if(is_null($value)) {
            return false;
        }

        if (!hasComma($value)) {
            return false;
        }

        return true;
    }

    protected function determineMethod($value)
    {
        return isDateTime($value) ? 'whereDate' : 'where';
    }

    protected function normalizeValues($values)
    {
        [$field, $val] = separateCommaValues($values);
        $this->normalized[$field] = $val;
    }
}
