<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class OrderbyClauseTest extends TestCase
{
    /** @test */
    public function a_sort_clause_with_empty_value_will_be_ignored()
    {
        $query = 'sort=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }

    /** @test */
    public function a_sort_clause_without_sort_type_can_be_performed_correctly()
    {
        $query = 'sort=name';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('ali', $decodedResponse[0]['name']);
        $this->assertEquals('reza', end($decodedResponse)['name']);
    }

    /** @test */
    public function a_sort_clause_with_sort_type_can_be_performed_correctly()
    {
        $query = 'sort=name,desc';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('reza', $decodedResponse[0]['name']);
        $this->assertEquals('ali', end($decodedResponse)['name']);
    }

    /** @test */
    public function a_sort_clause_with_two_fields_and_without_sort_type_can_be_performed_correctly()
    {
        $query = 'sort=name,created_at';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('ali', $decodedResponse[0]['name']);
        $this->assertEquals('reza', end($decodedResponse)['name']);

        $query = 'sort=created_at,name';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('ali', $decodedResponse[0]['name']);
        $this->assertEquals('mehrad', end($decodedResponse)['name']);
    }

    /** @test */
    public function a_sort_clause_with_two_fields_and_with_one_sort_type_can_be_performed_correctly()
    {
        $query = 'sort=name,created_at,desc';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('ali', $decodedResponse[0]['name']);
        $this->assertEquals('reza', end($decodedResponse)['name']);

        $query = 'sort=created_at,desc,name';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('mehrad', $decodedResponse[0]['name']);
        $this->assertEquals('ali', end($decodedResponse)['name']);
    }

    /** @test */
    public function a_sort_clause_with_two_fields_and_with_two_sort_type_can_be_performed_correctly()
    {
        $query = 'sort=age,desc,name,desc';

        $response = $this->get("/?$query");

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('omid', $decodedResponse[0]['name']);
        $this->assertEquals('reza', end($decodedResponse)['name']);
    }
}
