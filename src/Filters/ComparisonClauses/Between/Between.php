<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Mehradsadeghi\FilterQueryString\FilterContract;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class Between extends BaseComparison implements FilterContract
{
    use Betweener;

    protected $validationMessage = 'between statement should have two comma separated values.';

    public $method = 'whereBetween';
}
