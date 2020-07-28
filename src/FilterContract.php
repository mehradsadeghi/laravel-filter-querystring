<?php

namespace Mehradsadeghi\FilterQueryString;

interface FilterContract {
    public function __construct($query, $filter, $values);
    public function apply();
}