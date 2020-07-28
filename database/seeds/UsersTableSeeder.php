<?php

use Illuminate\Database\Seeder;
use Mehradsadeghi\FilterQueryString\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'mehrad',
                'email' => 'mehrad@example.com',
                'username' => 'mehrad',
                'age' => 20,
                'created_at' => '2020-12-01 01:00:00',
                'updated_at' => '2020-12-01 01:00:00',
            ],
            [
                'name' => 'reza',
                'email' => 'reza@example.com',
                'username' => 'reza',
                'age' => 20,
                'created_at' => '2020-11-01 01:00:00',
                'updated_at' => '2020-11-01 01:00:00',
            ],
            [
                'name' => 'omid',
                'email' => 'omid@example.com',
                'username' => 'omid',
                'age' => 22,
                'created_at' => '2020-10-01 01:00:00',
                'updated_at' => '2020-10-01 01:00:00',
            ],
            [
                'name' => 'ali',
                'email' => 'ali@example.com',
                'username' => 'ali',
                'age' => 22,
                'created_at' => '2020-09-01 01:00:00',
                'updated_at' => '2020-09-01 01:00:00',
            ],
        ];

        foreach ($users as $user) {
            factory(User::class)->create($user);
        }
    }
}
