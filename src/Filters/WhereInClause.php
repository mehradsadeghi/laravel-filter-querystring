<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereInClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide comma separated values for your where in clause.';

    public function apply()
    {
        [$field, $values] = $this->normalizeValues();

        $this->query->whereIn($field, $values);
    }

    public function validate($value)
    {
        parent::validate($value);

        if(count(separateCommaValues($value)) < 2) {
            throw new InvalidArgumentException($this->validationMessage);
        }
    }

    private function normalizeValues()
    {
        $elements = separateCommaValues($this->values);
        return [array_shift($elements), $elements];
    }
}
