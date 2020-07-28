<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    public function __construct($query, $filter, $values)
    {
        parent::__construct($query, $filter, $values);

        if (!$this->hasComma($this->values)) {
            return $this->query;
        }

        [$this->filter, $this->values] = $this->separateCommaValues($this->values);
    }
}
