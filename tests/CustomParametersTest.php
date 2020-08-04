<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;

class CustomParametersTest extends TestCase
{
    /** @test */
    public function filter_with_specific_parameters_can_be_performed_correctly()
    {
        Route::get('/', function () {
            return User::select('name')->filter('in')->get();
        });

        $query = 'in=name,mehrad,reza&like=name,mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }

    /** @test */
    public function filter_with_specific_parameters_can_be_performed_correctly2()
    {
        Route::get('/', function () {
            return User::select('name')->filter('in', 'name')->get();
        });

        $query = 'like=name,mehrad,reza,dariush,hossein&name[0]=mehrad&name[1]=hossein&username=mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(2);
    }
}
