<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
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
            $title = $faker->unique()->name;
            Post::create([
                'create_by'   => rand(1, 20),
                'category_id' => rand(1, 20),
                'title'       => $title,
                'slug'        => slugify($title),
                'sub_title'   => substr($faker->paragraph, 1, 50),
                'status'      => RandomStatus(),
                'image'       => $faker->imageUrl(),
                'description' => $faker->sentence
            ]);
        }
    }
}
