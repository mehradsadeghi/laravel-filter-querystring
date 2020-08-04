<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class Between extends BaseComparison
{
    use Betweener;

    public $method = 'whereBetween';
}
