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
                'created_at' => '2020-07-22',
                'updated_at' => '2020-07-22',
            ],
            [
                'name' => 'reza',
                'email' => 'reza@example.com',
                'username' => 'reza',
                'created_at' => '2020-07-23',
                'updated_at' => '2020-07-23',
            ],
            [
                'name' => 'omid',
                'email' => 'omid@example.com',
                'username' => 'omid',
                'created_at' => '2020-07-24',
                'updated_at' => '2020-07-24',
            ],
            [
                'name' => 'ali',
                'email' => 'ali@example.com',
                'username' => 'ali',
                'created_at' => '2020-07-25',
                'updated_at' => '2020-07-25',
            ],
        ];

        foreach ($users as $user) {
            factory(User::class)->create($user);
        }
    }
}
