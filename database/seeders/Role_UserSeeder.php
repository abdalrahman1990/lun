<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
           
            
            'role_id' =>'1',
            'user_id' =>'1',
            'created_at' => now(),
            'updated_at'=> now(),
            
        ]);

        DB::table('role_user')->insert([
           
            
            'role_id' =>'2',
            'user_id' =>'2',
            'created_at' => now(),
            'updated_at'=> now(),
            
        ]);
    }
}
