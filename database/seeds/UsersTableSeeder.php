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
        $users = $this->getStub();

        foreach ($users as $user) {
            factory(User::class)->create($user);
        }
    }

    private function getStub()
    {
        return [
            [
                'name' => 'mehrad',
                'email' => 'mehrad@example.com',
                'username' => 'mehrad',
                'age' => 20,
                'created_at' => '2020-09-01',
                'updated_at' => '2020-09-01',
            ],
            [
                'name' => 'reza',
                'email' => 'reza@example.com',
                'username' => 'reza',
                'age' => 20,
                'created_at' => '2020-10-01',
                'updated_at' => '2020-10-01',
            ],
            [
                'name' => 'hossein',
                'email' => 'hossein@example.com',
                'username' => 'hossein',
                'age' => 22,
                'created_at' => '2020-11-01',
                'updated_at' => '2020-11-01',
            ],
            [
                'name' => 'dariush',
                'email' => 'dariush@example.com',
                'username' => 'dariush',
                'age' => 22,
                'created_at' => '2020-12-01',
                'updated_at' => '2020-12-01',
            ],
        ];
    }
}
