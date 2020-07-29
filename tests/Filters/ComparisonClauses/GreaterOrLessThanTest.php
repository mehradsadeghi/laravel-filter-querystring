<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class GreaterOrLessThanTest extends TestCase
{
    /** @test */
    public function union_one_field_with_greater_or_less()
    {
        $query = 'greater_or_less=created_at,2020-11-01,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(3);
    }

    /** @test */
    public function greater_or_less_with_invalid_parameters_will_be_ignored()
    {
        $query = 'greater_or_less=created_at,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'greater_or_less=created_at';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'greater_or_less=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
