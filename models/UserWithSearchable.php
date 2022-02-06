<?php

namespace Mehradsadeghi\FilterQueryString\Models;

use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class UserWithSearchable extends Model
{
    protected $table='users';
    use FilterQueryString, UserFilters;

    protected $guarded = [];
    protected $searchable=[
        'name',
        'email'
    ];

}
