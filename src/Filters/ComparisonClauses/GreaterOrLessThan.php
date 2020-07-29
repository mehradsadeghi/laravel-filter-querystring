<?php

namespace Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\FilterContract;

class GreaterOrLessThan extends BaseComparison implements FilterContract
{
    public function apply()
    {
        foreach($this->normalized as $field => $values) {

            [$val1, $val2] = $values;

            $this->method = $this->determineMethod($val1);

            $this->query->where(function($query) use($field, $val1, $val2) {
                $query->{$this->method}($field, '>', $val1)
                    ->{'or'.ucfirst($this->method)}($field, '<', $val2);
            });
        }
    }

    protected function normalizeValues($values)
    {
        foreach((array)$values as $value) {

            if (!$this->hasComma($value)) {
                throw new InvalidArgumentException('comparison values should be comma separated.');
            }

            $exploded = explode(',', $value);

            if (count($exploded) != 3) {
                throw new InvalidArgumentException(
                    'greater or less than comparison should have two comma separated values.'
                );
            }

            [$field, $val1, $val2] = $exploded;

            $this->normalized[$field] = [$val1, $val2];
        }
    }
}
