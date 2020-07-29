<?php

namespace Mehradsadeghi\FilterQueryString\Filters;

use InvalidArgumentException;
use Mehradsadeghi\FilterQueryString\FilterContract;

class WhereLikeClause extends BaseClause implements FilterContract {

    private $explodedValue;

    public function apply()
    {
        $normalized = $this->normalizeValues();

        $this->query->where(function($query) use($normalized) {
            foreach ($normalized as $field => $value) {
                $query->orWhere($field, 'like', "%$value%");
            }
        });
    }

    protected function validate($message = null)
    {
        parent::validate($message);

        if(count($this->explodedValue) != 2) {
            throw new InvalidArgumentException($message);
        }
    }

    private function normalizeValues()
    {
        $normalized = [];

        foreach ((array) $this->values as $value) {

            $this->explodedValue = separateCommaValues($value);

            $this->validate('you should provide comma separated values for your where like clause.');

            [$field, $value] = $this->explodedValue;

            $normalized[$field] = $value;
        }

        return $normalized;
    }
}
