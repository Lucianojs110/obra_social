<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
        	'name' => 'Gonzalo',
        	'surname' => 'Gomez',
        	'email' => 'gonzaloholzmeister@gmail.com',
        	'password' => Hash::make('PHPKing192'),
        	'role' => 'Prestador'
        ]);
    }
}