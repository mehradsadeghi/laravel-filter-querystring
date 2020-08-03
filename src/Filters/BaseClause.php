<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

abstract class BaseClause {

    protected $query;
    protected $filter;
    protected $values;

    public function __construct($values, $filter) {

        $this->values = $values;
        $this->filter = $filter;
    }

    public function handle($query, $nextFilter)
    {
        $query = $nextFilter($query);

        try {

            static::validate($this->values);

        } catch (InvalidArgumentException $exception) {
            return $query;
        }

        return $this->apply($query);
    }

    abstract protected function apply($query): Builder;

    public function validate($value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException($this->validationMessage ?? '');
        }
    }
}
