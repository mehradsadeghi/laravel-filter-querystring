<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class NotBetween extends BaseComparison
{
    use Betweener;

    public $method = 'whereNotBetween';
}
