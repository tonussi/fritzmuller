<?php
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;

class UsersSeeder extends Seeder
{

    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createAdmins();
        $this->createUsers();
    }

    private function createAdmins()
    {
        User::firstOrCreate([
            'email' => 'fulanodetal@example.com',
            'name' => 'Fulano de tal',
            'password' => bcrypt('senhasecreta'),
            'is_admin' => true
        ]);

        User::firstOrCreate([
            'email' => 'siclanodetal@example.com',
            'name' => 'Siclano de tal',
            'password' => bcrypt('senhasecreta'),
            'is_admin' => false
        ]);
    }

    private function createUsers()
    {
        for ($i = 0; $i < 2; $i ++)
            $this->createUser();
    }

    private function createUser()
    {
        return User::firstOrCreate([
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => bcrypt(str_random(6))
        ]);
    }
}
