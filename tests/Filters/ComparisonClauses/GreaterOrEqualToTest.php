<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class GreaterOrEqualToTest extends TestCase
{
    /** @test */
    public function list_of_users_with_age_of_greater_or_equal_to_20_is_shown_correctly()
    {
        $query = 'greater_or_equal=age,20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(4);

        $query = 'greater_or_equal=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(3);
    }

    /** @test */
    public function greater_or_equal_with_undefined_field_or_value_will_be_ignored()
    {
        $query = 'greater_or_equal=20';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'greater_or_equal=age';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
