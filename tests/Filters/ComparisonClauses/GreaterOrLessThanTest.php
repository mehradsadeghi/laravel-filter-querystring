<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class GreaterOrLessThanTest extends TestCase
{
    /** @test */
    public function union_one_field_with_greater_or_less()
    {
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater_or_less=created_at,2020-11-01,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(3);
    }

    /** @test */
    public function union_two_fields_with_greater_or_less()
    {
        $this->withoutExceptionHandling();
        Route::get('/', function() {
            return User::select('name')->filter()->get();
        });

        $query = 'greater_or_less[0]=created_at,2020-11-01,2020-11-01&greater_or_less[1]=age,10,30';

        $response = $this->get("/?$query");

        $response->assertJsonCount(3);
    }
}
