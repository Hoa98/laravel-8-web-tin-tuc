<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            $item = [
                'name' => $faker->unique()->name,
                'cate_url'=> $faker->unique()->slug(),
                'logo' => "images/cate/cate-".($i+1).'.jpg',
                'created_at'=> now(),
            ];
            DB::table('categories')->insert($item);
        }
    }
}