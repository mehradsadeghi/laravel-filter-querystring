<?php

namespace Mehradsadeghi\FilterQueryString\Models;

use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class User extends Model
{
    use FilterQueryString, UserFilters;

    protected $guarded = [];
}
