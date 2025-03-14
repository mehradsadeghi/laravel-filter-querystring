<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Mehradsadeghi\FilterQueryString\Models\User;

class CustomFilterTest extends TestCase
{
    /** @test */
    public function young_custom_method()
    {
        $query = 'young=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'young=0';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }

    /** @test */
    public function young_and_old_custom_method()
    {
        $query = 'young=1&old=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function young_custom_method_and_in()
    {
        $query = 'young=0&in=name,mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }

    /** @test */
    public function alias_young_custom_method()
    {
        $query = 'alias_young=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'alias_young=0';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }

    /** @test */
    public function alias_young_and_old_custom_method()
    {
        $query = 'alias_young=1&alias_old=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function alias_young_custom_method_and_in()
    {
        $query = 'alias_young=0&in=name,mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }
}
