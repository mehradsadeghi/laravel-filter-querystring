<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use InvalidArgumentException;

trait Betweener
{
    public function apply()
    {
        $this->normalizeValues($this->values);

        foreach($this->normalized as $field => $values) {
            $this->query->{$this->method}($field, $values);
        }
    }

    public function validate($value)
    {
        foreach((array)$value as $item) {
            if (count(separateCommaValues($item)) != 3) {
                throw new InvalidArgumentException($this->validationMessage);
            }
        }
    }

    protected function normalizeValues($values)
    {
        foreach((array)$values as $value) {
            [$field, $val1, $val2] = separateCommaValues($value);
            $this->normalized[$field] = [$val1, $val2];
        }
    }
}
