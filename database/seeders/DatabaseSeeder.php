<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

            ];

            foreach($userdata as $key => $val){

                User::created($val);
            }
    }
}
