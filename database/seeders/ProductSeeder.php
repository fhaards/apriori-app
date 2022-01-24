<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x = 65;
        for ($i = $x; $i < 70; $i++) { 
            DB::table('products')->insert([
                'name' => 'Kursi Makan',
                'type' => 'KM0'.$x,
                'price' => 700000,
                'stock' => 20,
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
            $x++;
        }

    }
}
