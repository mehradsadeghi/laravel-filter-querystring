<?php

namespace Mehradsadeghi\FilterQueryString\Models;

trait UserFilters {

    protected $filters = [
        'sort',
        'greater',
        'greater_or_equal',
        'less',
        'less_or_equal',
        'between',
        'not_between',
        'in',
        'like',
        'name',
        'age',
        'username',
        'email',
        'young',
        'old'
    ];

    public function young($query, $value) {

        if($value == 1) {
            $query->where('age', '<', 20);
        }

        return $query;
    }

    public function old($query, $value) {

        if($value == 1) {
            $query->where('age', '>', 20);
        }

        return $query;
    }
}
