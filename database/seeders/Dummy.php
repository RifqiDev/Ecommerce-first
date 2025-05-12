<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Dummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userdata=[
        [
            'name'=>'Rifqi',
            'email' => 'rifqi@gmail.com',
            'role' => 'admin',
            'password' =>bcrypt('123456')
        ],
        [
            'name'=>'Doni',
            'email' => 'Doni@gmail.com',
            'role' => 'maneger',
            'password' =>bcrypt('123456')
        ],
        [
            'name'=>'Juki',
            'email' => 'Juki@gmail.com',
            'role' => 'user',
            'password' =>bcrypt('654321')
        ],

        ];

        foreach($userdata as $key => $val){

            User::create($val);
        }
    }
}
