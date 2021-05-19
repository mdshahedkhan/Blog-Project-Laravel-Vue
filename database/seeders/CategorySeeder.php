<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach (range(1, 50) as $item) {
            $name = $faker->unique()->name;
            Category::create([
                'name'   => $name,
                'slug'   => slugify($name),
                'status' => RandomStatus(),
            ]);

        }
    }
}
