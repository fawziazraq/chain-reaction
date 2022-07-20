<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {





        DB::table('users')->insert([
            'id' => 1 ,
            'name' => 'Fawzi Alazraq',
            'email' => 'fawzi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 1 ,
            'status' => 1
        ]);
        DB::table('user_details')->insert([
            'id' => 1 ,
            'jobTitle' => 'Software Engineering',
            'mobile' => '0770703828',
            'country' => 'UAE',
            'city' => 'Dubai'


        ]);




        for ($i=0; $i < 30; $i++) {

        DB::table('users')->insert([
            'name' => 'Ahmad '.Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'role' => null ,
            'status' => 1
        ]);




        DB::table('user_details')->insert([

            'jobTitle' => 'Software Engineering',
            'mobile' => Str::random(10),
            'country' => 'Jordan',
            'city' => 'Amman'


        ]);




    }





    }
}
