<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide a value for your where clause.';

    public function apply()
    {
        $method = is_array($this->values) ? 'orWhere' : 'andWhere';

        $this->{$method}($this->query, $this->filter, $this->values);
    }

    private function orWhere($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, $value);
            }
        });
    }

    private function andWhere($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, $value);
        }
    }
}
