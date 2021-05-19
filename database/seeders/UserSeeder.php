<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->Default();
        $faker = Factory::create();
        foreach (range(1, 50) as $item) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'password' => bcrypt($faker->password)
            ]);
        }
    }

    protected function Default()
    {
        User::create([
            'name'     => 'Md Shahed Khan',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
