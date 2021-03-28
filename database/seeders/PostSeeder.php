<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $item = [
                'title' => $faker->unique()->name,
                'post_url' => $faker->unique()->slug(),
                'cate_id'=> rand(1,10),
                'image'=> "images/post/post-".rand(1,20).'.jpg',
                'author'=> $faker->name,
                'content' => $faker->realText(300, 2),
                'short_desc' => $faker->realText(50, 2),
                'created_at'=> now(),
            ];
            DB::table('posts')->insert($item);
        }
    }
}