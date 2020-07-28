<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;

class LessThanTest extends TestCase
{
    /** @test */
    public function list_of_users_with_age_of_less_to_22_is_shown_correctly()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'less=age,22';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);

        $query = 'less=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function less_with_undefined_field_or_value_will_be_ignored()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'less=20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'less=age';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
