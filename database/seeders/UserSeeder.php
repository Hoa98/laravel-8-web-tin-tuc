<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_lst = [
            [
                'name' => 'Admin',
                'email' => 'hoactph09598@fpt.edu.vn',
                'password' => Hash::make('123456'),
                'avatar'=> 'images/user-default.jpg',
                'role'=> 1,
                'email_verified_at'=>now(),
                'created_at'=> now(),
            ],
            [
                'name' => 'menber',
                'email' => 'hoact98bg@gmail.com',
                'password' => Hash::make('123456'),
                'avatar'=> 'images/user-default.jpg',
                'role'=> 2,
                'email_verified_at'=>now(),
                'created_at'=> now(),
            ]
        ];

        foreach($user_lst as $item){
            $model = new User();
            $model->fill($item);
            $model->save();
        }
        
    }
}