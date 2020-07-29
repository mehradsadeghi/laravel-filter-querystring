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
        dd($response->getContent());

        $response->assertJsonCount(User::count());
    }
}
