<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;

class C_vSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('c_vs')->insert([
            
            'file'   =>'http://lorempixel.com/gray/800/400/cats/Faker/',
            'status'  =>'Pending',
            'job_id'  =>'1', 
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('c_vs')->insert([
            
            'file'   =>'http://lorempixel.com/gray/800/400/cats/Faker/',
            'status'  =>'Accepted',
            'job_id'  =>'1', 
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('c_vs')->insert([
            
            'file'   =>'http://lorempixel.com/gray/800/400/cats/Faker/',
            'status'  =>'Rejected',
            'job_id'  =>'1', 
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);
    }
}
