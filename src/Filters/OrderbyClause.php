<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\FilterContract;

class OrderbyClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide a value for your order by clause.';

    public function apply()
    {
        foreach ($this->normalizeValues() as $field => $order) {
            $this->query->orderBy($field, $order);
        }
    }

    public function validate($value) {
        foreach ((array)$value as $item) {
            parent::validate($item);
        }
    }

    private function normalizeValues()
    {
        $normalized = [];

        foreach ((array)$this->values as $value) {

            $exploded = separateCommaValues($value);

            if (!empty($exploded[1]) and in_array($exploded[1], ['asc', 'desc'])) {
                $normalized[$exploded[0]] = $exploded[1];
                continue;
            }

            $normalized[$exploded[0]] = 'asc';
        }

        return $normalized;
    }
}
