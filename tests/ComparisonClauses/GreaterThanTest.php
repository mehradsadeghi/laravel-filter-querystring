<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;

class GreaterThanTest extends TestCase
{
    /** @test */
    public function list_of_users_with_age_of_greater_than_20_is_shown_correctly()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater=age,20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function greater_than_with_undefined_field_or_value_will_be_ignored()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater=20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'greater=age';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
