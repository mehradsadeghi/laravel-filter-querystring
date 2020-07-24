<?php

namespace Mehradsadeghi\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use Mehradsadeghi\FilterQueryString\Models\User;

class BasicTest extends TestCase
{
    /** @test */
    public function sample()
    {
        Route::get('/', function() {
            return User::all();
        });

        $response = $this->get('/');

        dd($response->getContent());

        $this->assertTrue(true);
    }
}
