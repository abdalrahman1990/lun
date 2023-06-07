<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            'name'     => Str::random(10),
            'email'    => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'pic'   => 'https://i.ibb.co/jDsy3Ff/303957017-1064253077587834-2681826611010764877-n.jpg',
            'phone' =>'1558127349',
            'remember_token' =>Str::random(60), 
            
        ]);
    }
}
