<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereInClause extends BaseClause implements FilterContract {

    public function apply()
    {
        $this->validate('you should provide comma separated values for your where in clause.');

        [$field, $values] = $this->normalizeValues();

        $this->query->whereIn($field, $values);
    }

    protected function validate($message = null)
    {
        parent::validate($message);

        if(count(separateCommaValues($this->values)) < 2) {
            throw new InvalidArgumentException($message);
        }
    }

    private function normalizeValues()
    {
        $elements = separateCommaValues($this->values);
        return [array_shift($elements), $elements];
    }
}
