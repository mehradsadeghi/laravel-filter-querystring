<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Mehradsadeghi\FilterQueryString\FilterContract;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class NotBetween extends BaseComparison implements FilterContract
{
    use Betweener;

    public $method = 'whereNotBetween';
}
