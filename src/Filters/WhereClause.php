<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereClause extends BaseClause implements FilterContract {

    public function apply()
    {
        $this->validate('you should provide a value for your where clause.');

        if(is_array($this->values)) {
            return $this->orWhere($this->query, $this->filter, $this->values);
        } else {
            return $this->andWhere($this->query, $this->filter, $this->values);
        }
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
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->where($filter, $value);
            }
        });

        return $query;
    }
}
