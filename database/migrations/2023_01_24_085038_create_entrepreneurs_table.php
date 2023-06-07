<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrepreneursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrepreneurs', function (Blueprint $table) {
            $table->id();
            $table->json('step1')->nullable();
            $table->json('step2')->nullable();
            $table->json('step3')->nullable();
            $table->json('step4')->nullable();
            $table->json('step5')->nullable();
            $table->json('step6')->nullable();
            $table->json('step7')->nullable();
            $table->json('step8')->nullable();
            $table->json('step9')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrepreneurs');
    }
}
