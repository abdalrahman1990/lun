<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
   
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title');
            $table->string('type')->nullable();
            $table->string('hierarchical')->nullable();
            $table->integer('salary')->nullable();
            $table->string('address')->nullable();
            $table->string('experience')->nullable();
            $table->string('description')->nullable();
            $table->string('requirement');
            $table->enum('status', ['Pending', 'Opened', 'Closed'])->default('Pending');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });


    }

    public function down()
    {
        Schema::dropIfExists('jobs');
        $table->dropSoftDeletes();
    }


}
