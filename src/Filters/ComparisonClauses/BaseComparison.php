<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    protected $isDateTime = false;
    protected $method = 'where';

    public function __construct($query, $filter, $values)
    {
        parent::__construct($query, $filter, $values);

        if (!$this->hasComma($this->values)) {
            throw new InvalidArgumentException('comparison values should be comma separated.');
        }

        [$this->filter, $this->values] = $this->separateCommaValues($this->values);

        $this->method = $this->determineMethod();
    }

    public function apply()
    {
        $this->query->{$this->method}($this->filter, $this->operator, $this->values);
    }

    protected function isDateTime($value)
    {
        return date_parse($value)['error_count'] < 1;
    }

    private function determineMethod()
    {
        return $this->isDateTime($this->values) ? 'whereDate' : $this->method;
    }
}
