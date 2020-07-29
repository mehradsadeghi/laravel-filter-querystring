<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class CombinationTest extends TestCase
{
    /** @test */
    public function unite_two_different_fields_with_greater()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater[0]=age,20&greater[1]=created_at,2020-09-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function unite_two_different_fields_with_greater_and_less()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater=age,20&less=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function union_one_field_with_greater_and_less()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater=created_at,2020-11-01&less=created_at,2020-11-01';

        $response = $this->get("/?$query");
        dd($response->getContent());

        $response->assertJsonCount(1);
    }
}
