<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters;

use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class CombinationTest extends TestCase
{
    /** @test */
    public function combination1()
    {
        $query = 'name[0]=mehrad&name[1]=reza&between=age,20,30&sort=created_at';

        $response = $this->get("/?$query");
        $decodedResponse = $response->decodeResponseJson();

        $response->assertJsonCount(2);
        $this->assertEquals('reza', $decodedResponse[0]['name']);
    }

    /** @test */
    public function combination2()
    {
        $query = 'like[0]=name,meh&like[1]=name,rez&like[2]=name,omi&less=age,21&sort=created_at,desc';

        $response = $this->get("/?$query");
        $decodedResponse = $response->decodeResponseJson();

        $response->assertJsonCount(2);
        $this->assertEquals('mehrad', $decodedResponse[0]['name']);
    }

    /** @test */
    public function combination3()
    {
        $query = 'greater_or_equal=age,21&sort=created_at,desc';

        $response = $this->get("/?$query");
        $decodedResponse = $response->decodeResponseJson();

        $response->assertJsonCount(2);
        $this->assertEquals('omid', $decodedResponse[0]['name']);
    }

    /** @test */
    public function combination4()
    {
        $query = 'in=name,mehrad,reza,omid&not_between=age,22,30&sort=updated_at';

        $response = $this->get("/?$query");
        $decodedResponse = $response->decodeResponseJson();

        $response->assertJsonCount(2);
        $this->assertEquals('reza', $decodedResponse[0]['name']);
    }
}
