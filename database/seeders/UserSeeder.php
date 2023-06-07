<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use Hash;

class UserSeeder extends Seeder
{
   
    public function run()
    {
       
        DB::table('users')->insert([
            'name'  => 'admin',
            'email' =>'admin@lun.sa',
            'password' => Hash::make('secret'),
            'pic'      => 'https://i.ibb.co/jDsy3Ff/303957017-1064253077587834-2681826611010764877-n.jpg',
            'phone'    =>'1558127349',
            'remember_token' =>Str::random(60), 
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

      
    }
    
}
