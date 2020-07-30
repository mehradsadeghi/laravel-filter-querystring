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
        if (count(separateCommaValues($value)) != 3) {
            throw new InvalidArgumentException($this->validationMessage);
        }
    }

    protected function normalizeValues($values)
    {
        [$field, $val1, $val2] = separateCommaValues($values);
        $this->normalized[$field] = [$val1, $val2];
    }
}
