<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class GreaterThan extends BaseComparison implements FilterContract
{
    public $operator = '>';
}
