<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class BetweenTest extends TestCase
{
    /** @test */
    public function list_of_user_with_age_between_20_and_40()
    {
        $query = 'between=age,20,40';

        $response = $this->get("/?$query");

        $response->assertJsonCount(4);
    }

    /** @test */
    public function list_of_user_with_age_between_10_and_20()
    {
        $query = 'between=age,10,20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function between_statement_with_invalid_parameters_will_be_ignored()
    {
        $query = 'between=created_at,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'between=created_at';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'between=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'between=created_at,2020-11-01,2020-12-01,2020-09-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
