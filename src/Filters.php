<?php

namespace Mehradsadeghi\FilterQueryString;

trait Filters {

    // supported:
    /*
     * simple `where`
     * multiple where with `where`
     * simple `order_by`
     * multiple `order_by`s
     * after
     * equal_or_after
     * before
     * equal_or_before
     */

    // make a module and make github repository for it

    // helpers:
    // created_at
    // updated_at

    // features:
    // mapping different names from what we use in query string

    // WHERE person = 'lake' OR person = 'roe';
    // WHERE person IN ('lake', 'roe');
    // WHERE quant = 'sal' AND person = 'lake' OR person = 'roe';
    // WHERE site LIKE 'DR%';
    // WHERE (lat > -48) OR (lat < 48);
    // price[min]=2620408&price[max]=8527245&
    // multiple where with `Orwhere`

    /**
     * The minimum mandatory count of values in query string, After it's exploded by comma, for each method.
     *
     * @var int[]
     */
    private $minValueCountRules = [
        // todo think of a better way for this part
        'defaultFilter' => 1,
        'after' => 2,
        'equal_or_after' => 2,
        'before' => 2,
        'equal_or_before' => 2,
        'order_by' => 1,
    ];

    protected function after($query, $value)
    {
        [$field, $value] = $this->separateCommaValues($value);
        return $query->where($field, '>', $value);
    }

    protected function equal_or_after($query, $value)
    {
        [$field, $value] = $this->separateCommaValues($value);
        return $query->where($field, '>=', $value);
    }

    protected function before($query, $value)
    {
        [$field, $value] = $this->separateCommaValues($value);
        return $query->where($field, '<', $value);
    }

    protected function equal_or_before($query, $value)
    {
        [$field, $value] = $this->separateCommaValues($value);
        return $query->where($field, '<=', $value);
    }

    protected function order_by($query, $value)
    {
        foreach ((array)$value as $orderBy) {
            [$field, $order] = explode(',', $orderBy);
            $query->orderBy($field, $order ?? 'asc');
        }

        return $query;
    }

    protected function defaultFilter($query, $filter, $values)
    {
        if(is_array($values)) {
            return $this->orWhere($query, $filter, $values);
        } else {
            return $this->andWhere($query, $filter, $values);
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
