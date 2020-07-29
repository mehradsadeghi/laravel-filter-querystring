<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class NotBetweenTest extends TestCase
{
    /** @test */
    public function list_of_user_with_age_not_between_22_and_40()
    {
        $query = 'not_between=age,22,40';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function list_of_user_with_age_not_between_20_and_30()
    {
        $query = 'not_between=age,20,30';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function list_of_user_with_age_not_between_10_and_20_and_created_at_not_between()
    {
        $query = 'not_between[0]=age,10,20&between[1]=created_at,2020-10-01,2020-12-02';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function not_between_statement_with_invalid_parameters_will_be_ignored()
    {
        $query = 'not_between=created_at,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'not_between=created_at';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'not_between=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'not_between=created_at,2020-11-01,2020-12-01,2020-09-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
