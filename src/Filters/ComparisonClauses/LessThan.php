<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class LessThan extends BaseComparison implements FilterContract
{
    public $operator = '<';
}
