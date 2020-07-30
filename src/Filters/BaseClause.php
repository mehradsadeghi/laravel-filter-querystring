<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use InvalidArgumentException;

abstract class BaseClause {

    public $query;
    public $filter;
    public $values;

    public function __construct($query, $filter, $values)
    {
        $this->query = $query;
        $this->filter = $filter;
        $this->values = $values;
    }

    public function validate($value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException($this->validationMessage ?? '');
        }
    }
}
