<?php

namespace Mehradsadeghi\FilterQueryString;

trait FilterQueryString {

    use Filters;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->unguardFilters = $this->unguardFilters ?? false;
    }

    public function scopeFilter($query)
    {
        foreach($this->getFilters() as $filter => $value) {

            if(method_exists($this, $filter)) {
                $this->{$filter}($query, $value);
            } else {
                $this->defaultFilter($query, $filter, $value);
            }
        }

        return $query;
    }

    protected function getFilters()
    {
        $filter = function ($key) {
            return !$this->unguardFilters ? in_array($key, $this->filters) : true;
        };

        // todo try to separate http from here
        return array_filter(request()->query->all(), $filter, ARRAY_FILTER_USE_BOTH) ?? [];
    }

    private function separateCommaValues($value)
    {
        return explode(',', $value);
    }

    private function validateValue($key, $value)
    {
        return !is_null($value) and $this->validateCountOfValues($key, $value);
    }

    private function validateCountOfValues($key, $value)
    {
        $mandatoryCount = $this->minValueCountRules[$key] ?? $this->minValueCountRules['defaultFilter'];
        return count($this->separateCommaValues($value)) >= $mandatoryCount;
    }
}
