<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class CombinationTest extends TestCase
{
    /** @test */
    public function unite_two_different_fields_with_greater_and_less()
    {
        $query = 'greater=age,20&less=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }
}
