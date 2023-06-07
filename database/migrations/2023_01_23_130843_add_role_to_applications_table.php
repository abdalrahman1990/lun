<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {

            $table->string('role')->nullable()->after('status');
            $table->string('investment_domain')->nullable()->after('role');
            $table->string('investment_phase')->nullable()->after('investment_domain');
            $table->integer('max_limit')->nullable()->after('investment_phase');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
           
            $table->dropColumn('role');
            $table->dropColumn('investment_domain)');
            $table->dropColumn('investment_phase');
            $table->dropColumn('max_limit');

        });
    }
}
