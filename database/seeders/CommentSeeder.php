<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $posts = Post::all();

        foreach($posts as $p){
            $item = [
                'post_id'=> $p->id,
                'user_id'=> rand(1,2),
                'content' => $faker->realText(50, 2),
                'status' => $faker->boolean,
                'created_at'=> now(),
            ];
            DB::table('comments')->insert($item);
        }
        
    }
}