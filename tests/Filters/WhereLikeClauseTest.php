<?php

namespace Mehradsadeghi\FilterQueryString\Tests\Filters;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;
use Mehradsadeghi\FilterQueryString\Tests\TestCase;

class WhereLikeClauseTest extends TestCase
{
    /** @test */
    public function a_where_like_clause_can_be_performed()
    {
        $query = 'like=name,meh';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function two_where_like_clauses_can_be_performed()
    {
        $query = 'like[0]=name,meh&like[1]=email,reza';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);

        $query = 'like[0]=name,meh&like[1]=name,rez';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function where_like_clause_with_invalid_values_will_be_ignored()
    {
        $query = 'like=';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());

        $query = 'like=name';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
