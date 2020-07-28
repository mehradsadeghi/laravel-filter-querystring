<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;

class WhereClauseTest extends TestCase
{
    /** @test */
    public function a_where_clause_can_be_performed_correctly()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'name=mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
        $response->assertJson([['name' => 'mehrad']]);

        $query = 'name=reza';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
        $response->assertJson([['name' => 'reza']]);
    }

    /** @test */
    public function two_non_array_will_unite_the_result()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'name=mehrad&username=omid';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'name=mehrad&username=mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
        $response->assertJson([['name' => 'mehrad']]);
    }

    /** @test */
    public function a_where_query_with_wrong_field_name_will_be_ignored()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'wrong_field=mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'name=mehrad&wrong_field=omid';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function no_query_will_be_performed_without_using_filter_eloquent_method()
    {
        Route::get('/', function() {
            return User::select('name')->get();
        });

        $query = 'name=mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }

    /** @test */
    public function two_values_of_one_field_will_union_the_result()
    {
        Route::get('/', function() {
            return User::filter()->select('name')->get();
        });

        $query = 'name[0]=mehrad&name[1]=omid';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function two_values_of_two_fields_will_union_internally_and_unite_externally_the_result()
    {
        Route::get('/', function() {
            return User::filter()->select('name')->get();
        });

        $query = 'name[0]=mehrad&name[1]=omid&username[0]=reza&username[1]=ali';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function two_values_of_one_field_and_one_value_of_another_field_will_unite_the_result()
    {
        Route::get('/', function() {
            return User::filter()->select('name')->get();
        });

        $query = 'name[0]=mehrad&name[1]=reza&username=omid';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function two_values_of_two_fields_and_one_value_of_another_field_will_unite_the_result()
    {
        Route::get('/', function() {
            return User::filter()->select('name')->get();
        });

        $query = 'name[0]=mehrad&name[1]=reza&username[0]=omid&username[1]=mehrad&email=mehrad@example.com';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);

        $query = 'name[0]=mehrad&name[1]=reza&username[0]=omid&username[1]=mehrad&email=ali@example.com';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }
}
