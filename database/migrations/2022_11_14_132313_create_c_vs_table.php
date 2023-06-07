<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCVsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_vs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file');
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->foreignId('job_id')->referance('id')->on('jobs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_vs');
    }
}
