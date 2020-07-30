<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Mehradsadeghi\FilterQueryString\FilterContract;
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class NotBetween extends BaseComparison implements FilterContract
{
    use Betweener;

    protected $validationMessage = 'not between statement should have two comma separated values.';

    public $method = 'whereNotBetween';
}
