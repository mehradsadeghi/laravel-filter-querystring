<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Mehradsadeghi\FilterQueryString\FilterContract;

class OrderbyClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide a value for your order by clause.';

    public function apply()
    {
        if(!hasComma($this->values)) {
            return $this->query->orderBy($this->values, 'asc');
        }

        foreach ($this->normalizeValues() as $field => $order) {
            $this->query->orderBy($field, $order);
        }
    }

    private function normalizeValues()
    {
        $normalized = [];

        foreach ((array)$this->values as $value) {

            [$partOne, $partTwo] = separateCommaValues($value);

            if (in_array($partTwo, ['asc', 'desc'])) {
                $normalized[$partOne] = $partTwo;
                continue;
            }

            $normalized[$partTwo] = $normalized[$partOne] = 'asc';
        }

        return $normalized;
    }
}
