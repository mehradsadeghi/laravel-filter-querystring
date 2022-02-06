<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Models\UserWithSearchable;

class SearchablePropertyTest extends TestCase
{
    public function test_not_existed_column_in_searchable_property_will_removed(){
        Route::get('/', function () {
            return UserWithSearchable::select('name')->filter()->get();
        });
        $query = 'like=not_existed_column,value';
        $response = $this->get("/?$query");
        $response->assertJsonCount(4);
    }
    public function test_existed_column_in_searchable_property_will_apply(){
        Route::get('/', function () {
            return UserWithSearchable::select('name')->filter()->get();
        });
        $query = 'like=name,mehr';
        $response = $this->get("/?$query");
        $response->assertJsonCount(1);
    }
}