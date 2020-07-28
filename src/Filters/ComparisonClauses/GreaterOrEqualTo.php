<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class GreaterOrEqualTo extends BaseComparison implements FilterContract
{
    public function apply()
    {
        $this->query->where($this->filter, '>=', $this->values);
    }
}
