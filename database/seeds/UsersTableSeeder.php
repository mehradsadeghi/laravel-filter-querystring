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
                'email' => 'm@m.com',
                'username' => 'm',
                'created_at' => '2020-07-22',
                'updated_at' => '2020-07-22',
            ],
            [
                'name' => 'reza',
                'email' => 'r@m.com',
                'username' => 'r',
                'created_at' => '2020-07-23',
                'updated_at' => '2020-07-23',
            ],
            [
                'name' => 'omid',
                'email' => 'o@m.com',
                'username' => 'o',
                'created_at' => '2020-07-24',
                'updated_at' => '2020-07-24',
            ],
        ];

        foreach ($users as $user) {
            factory(User::class)->create($user);
        }
    }
}
