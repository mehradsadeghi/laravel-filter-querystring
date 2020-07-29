<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters\ComparisonClauses;

use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class CombinationTest extends TestCase
{
    /** @test */
    public function unite_two_different_fields_with_greater()
    {
        $query = 'greater[0]=age,20&greater[1]=created_at,2020-09-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function unite_two_different_fields_with_less()
    {
        $query = 'less[0]=age,22&less[1]=created_at,2020-12-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function unite_two_different_fields_with_greater_and_less()
    {
        $query = 'greater=age,20&less=created_at,2020-10-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function unite_two_fields_with_greater_or_less()
    {
        $query = 'greater_or_less[0]=created_at,2020-11-01,2020-11-01&greater_or_less[1]=age,10,30';

        $response = $this->get("/?$query");

        $response->assertJsonCount(3);
    }

    /** @test */
    public function unite_greater_or_less_and_greater()
    {
        $query = 'greater_or_less=age,30,21&greater=created_at,2020-11-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }
}
