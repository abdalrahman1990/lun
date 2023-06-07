<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class Job_titleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs_title')->insert([
            
            'title'   =>'FullStack Developer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Backend Developer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Flutter Developer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Product Owner',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Business Analysis',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Graphic Designer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Project Manager',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'SEO Engineer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'DevOps Engineer',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Team Lead/Engineering Lead',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);

        DB::table('jobs_title')->insert([
            
            'title'   =>'Data Scientist',
            'created_at'     => now(),
            'updated_at'     => now(),
            
        ]);
    }
}
