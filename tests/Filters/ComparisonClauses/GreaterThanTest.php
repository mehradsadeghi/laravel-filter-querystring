<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class GreaterThanTest extends TestCase
{
    /** @test */
    public function list_of_users_with_age_of_greater_than_20_is_shown_correctly()
    {
        $query = 'greater=age,20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);

        $query = 'greater=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function greater_than_with_undefined_field_or_value_will_be_ignored()
    {
        $query = 'greater=20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'greater=age';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
