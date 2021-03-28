<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class ViewSeeder extends Seeder
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
        
            for ($i = 10; $i > 0; $i--) {
                foreach($posts as $post){
                if ($i==0) {
                    $item = [
                        'post_id'=> $post->id,
                        'views' => rand(1,10),
                        'created_date' => Carbon::now(),
                        'created_at'=> Carbon::now(),
                    ];
                }elseif($i==1){
                    $item = [
                        'post_id'=> $post->id,
                        'views' => rand(1,10),
                        'created_date' => Carbon::now()->subDay(),
                        'created_at'=> Carbon::now()->subDay(),
                    ];
                }else{
                    $item = [
                        'post_id'=> $post->id,
                        'views' => rand(1,10),
                        'created_date' => Carbon::now()->subDays($i),
                        'created_at'=> Carbon::now()->subDays($i),
                    ];
                }
                DB::table('views')->insert($item);
            }
        }
       
    }
}