<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDescriptionToJobsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            DB::statement('ALTER TABLE jobs MODIFY description  text;');
            DB::statement('ALTER TABLE jobs MODIFY requirement  text;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {

            DB::statement('ALTER TABLE jobs MODIFY description string;');
            DB::statement('ALTER TABLE jobs MODIFY requirement string;');
            
        });
    }
}
