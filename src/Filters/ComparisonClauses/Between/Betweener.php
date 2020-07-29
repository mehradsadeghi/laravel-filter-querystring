<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use InvalidArgumentException;

trait Betweener
{
    private $explodedValue;

    public function apply()
    {
        foreach($this->normalized as $field => $values) {
            $this->query->{$this->method}($field, $values);
        }
    }

    protected function validate($message = null)
    {
        parent::validate($message);

        if (count($this->explodedValue) != 3) {
            throw new InvalidArgumentException($message);
        }
    }

    protected function normalizeValues($values)
    {
        foreach((array)$values as $value) {

            $this->explodedValue = separateCommaValues($value);

            $this->validate('between statement should have two comma separated values.');

            [$field, $val1, $val2] = $this->explodedValue;

            $this->normalized[$field] = [$val1, $val2];
        }
    }
}
