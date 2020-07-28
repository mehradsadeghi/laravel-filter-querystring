<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class GreaterThan extends BaseComparison implements FilterContract
{
    public function apply()
    {
        $this->query->{$this->method}($this->filter, '>', $this->values);
    }
}
