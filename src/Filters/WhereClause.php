<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide a value for your where clause.';

    public function apply($query): Builder
    {
        $method = is_array($this->values) ? 'orWhere' : 'andWhere';

        return $this->{$method}($query, $this->filter, $this->values);
    }

    private function orWhere($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, $value);
            }
        });

        return $query;
    }

    private function andWhere($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, $value);
        }

        return $query;
    }
}
