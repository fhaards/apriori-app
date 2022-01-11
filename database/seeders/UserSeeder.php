<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        // FAKER 
        // $faker = Faker::create();
        // for ($i = 0; $i <= 5; $i++) {
        //     DB::table('tb_users')->insert([
        //         'username' => $faker->userName,
        //         'name' => $faker->name,
        //         'password' => Hash::make('12345678'),
        //         'verified_at' => now(),
        //         'created_at'  => now(),
        //         'updated_at'  => now()
        //     ]);
        // }
    }
}
