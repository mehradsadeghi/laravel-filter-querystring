<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Mehradsadeghi\FilterQueryString\FilterContract;

class OrderbyClause extends BaseClause implements FilterContract {

    public function apply()
    {
        $this->validate('you should provide a value for your order by clause.');

        if(!$this->hasComma($this->values)) {
            return $this->query->orderBy($this->values, 'asc');
        }

        // normalizing
        $normalized = [];
        foreach ((array)$this->values as $value) {
            [$partOne, $partTwo] = $this->separateCommaValues($value);

            if(!in_array($partTwo, ['acs', 'desc'])) {
                $normalized[$partOne] = 'asc';
                $normalized[$partTwo] = 'asc';
            } else {
                $normalized[$partOne] = $partTwo;
            }
        }

        foreach ($normalized as $field => $order) {
            $this->query->orderBy($field, $order);
        }
    }
}
