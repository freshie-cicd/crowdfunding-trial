<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrators')->insert(array(
        	array(
    'name' => "admin",
    'email' => 'admin@gmail.com',
    'password' => bcrypt('admin'),
        	),
        	array(
    'name' => "ahkafy",
    'email' => 'ahkafy@gmail.com',
    'password' => bcrypt('ahkafy'),
            ),
            array(
    'name' => "Freshie.Farm",
    'email' => 'wOwsome@freshie.farm',
    'password' => bcrypt('mewMew#234'),
            )
        ));
    }
}
