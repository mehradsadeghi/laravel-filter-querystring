<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereLikeClause extends BaseClause implements FilterContract {

    protected $validationMessage = 'you should provide comma separated values for your where like clause.';

    public function apply($query): Builder
    {
        $normalized = $this->normalizeValues();

        $query->where(function($query) use($normalized) {
            foreach ($normalized as $field => $values) {
                foreach ($values as $value) {
                    $query->orWhere($field, 'like', "%$value%");
                }
            }
        });

        return $query;
    }

    public function validate($value)
    {
        parent::validate($value);

        foreach ((array) $value as $item) {
            if(count(separateCommaValues($item)) != 2) {
                throw new InvalidArgumentException($this->validationMessage);
            }
        }
    }

    private function normalizeValues()
    {
        $normalized = [];

        foreach ((array) $this->values as $value) {
            [$field, $value] = separateCommaValues($value);
            $normalized[$field][] = $value;
        }

        return $normalized;
    }
}
