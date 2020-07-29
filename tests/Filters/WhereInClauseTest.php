<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters;

use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class WhereInClauseTest extends TestCase
{
    /** @test */
    public function a_wherein_clause_can_be_performed()
    {
        $query = 'in=name,mehrad,reza';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }
    
    /** @test */
    public function wherein_clause_with_empty_field_and_values_will_be_ignored()
    {
        $query = 'in=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
    
    /** @test */
    public function wherein_clause_with_empty_values()
    {
        $query = 'in=name';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
