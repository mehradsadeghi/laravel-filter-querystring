<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

trait Betweener
{
    public function apply($query): Builder
    {
        $this->normalizeValues($this->values);

        foreach($this->normalized as $field => $values) {
            $query->{$this->method}($field, $values);
        }

        return $query;
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
