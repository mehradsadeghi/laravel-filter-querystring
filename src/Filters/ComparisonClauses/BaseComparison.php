<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\Filters\BaseClause;

abstract class BaseComparison extends BaseClause
{
    protected $validationMessage = 'comparison values should be comma separated.';

    protected $isDateTime = false;
    protected $method;
    protected $normalized = [];

    public function apply()
    {
        $this->normalizeValues($this->values);

        foreach ($this->normalized as $field => $value) {
            $this->query->{$this->determineMethod($value)}($field, $this->operator, $value);
        }
    }

    public function validate($value) {

        parent::validate($value);

        foreach ((array)$value as $item) {
            if (!hasComma($item)) {
                throw new InvalidArgumentException($this->validationMessage);
            }
        }
    }

    protected function determineMethod($value)
    {
        return isDateTime($value) ? 'whereDate' : 'where';
    }

    protected function normalizeValues($values)
    {
        foreach ((array)$values as $value) {
            [$field, $val] = separateCommaValues($value);
            $this->normalized[$field] = $val;
        }
    }
}
