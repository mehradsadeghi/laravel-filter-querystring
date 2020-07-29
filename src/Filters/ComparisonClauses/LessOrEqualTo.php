<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class LessOrEqualTo extends BaseComparison implements FilterContract
{
    public $operator = '<=';
}
