<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(Role_UserSeeder::class);
        $this->call(job_titleSeeder::class);
       // $this->call(C_vSeeder::class);
       // \App\Models\Job::factory(10)->create();
       // \App\Models\Application::factory(10)->create();
    }
}