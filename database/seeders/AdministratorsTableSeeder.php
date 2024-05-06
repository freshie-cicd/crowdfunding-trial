<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('administrators')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
            ],
            [
                'name' => 'ahkafy',
                'email' => 'ahkafy@gmail.com',
                'password' => bcrypt('ahkafy'),
            ],
            [
                'name' => 'Freshie.Farm',
                'email' => 'wOwsome@freshie.farm',
                'password' => bcrypt('mewMew#234'),
            ],
        ]);
    }
}
