<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    protected $isDateTime = false;
    protected $method;
    protected $normalized = [];

    public function __construct($query, $filter, $values)
    {
        parent::__construct($query, $filter, $values);

        $this->normalizeValues($values);
    }

    public function apply()
    {
        foreach ($this->normalized as $field => $value) {
            $this->query->{$this->determineMethod($value)}($field, $this->operator, $value);
        }
    }

    protected function isDateTime($value)
    {
        return date_parse($value)['error_count'] < 1;
    }

    protected function determineMethod($value)
    {
        return $this->isDateTime($value) ? 'whereDate' : 'where';
    }

    protected function normalizeValues($values)
    {
        foreach ((array)$values as $value) {

            if (!$this->hasComma($value)) {
                throw new InvalidArgumentException('comparison values should be comma separated.');
            }

            [$field, $val] = $this->separateCommaValues($value);

            $this->normalized[$field] = $val;
        }
    }
}
