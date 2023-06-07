<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteAtToCVsTable extends Migration
{
   
    public function up()
    {
        Schema::table('c_vs', function (Blueprint $table) {
            
            $table->softDeletes();
        });
    }

   
    public function down()
    {
        Schema::table('c_vs', function (Blueprint $table) {
            
            $table->dropSoftDelete();
        });
    }
}
