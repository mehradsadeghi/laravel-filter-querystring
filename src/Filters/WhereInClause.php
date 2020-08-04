<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class WhereInClause extends BaseClause {

    public function apply($query): Builder
    {
        [$field, $values] = $this->normalizeValues();

        return $query->whereIn($field, $values);
    }

    public function validate($value): bool
    {
        if(is_null($value)) {
            return false;
        }

        if(count(separateCommaValues($value)) < 2) {
            return false;
        }

        return true;
    }

    private function normalizeValues()
    {
        $elements = separateCommaValues($this->values);
        return [array_shift($elements), $elements];
    }
}
