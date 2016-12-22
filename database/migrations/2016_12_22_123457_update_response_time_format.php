<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResponseTimeFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_updates', function (Blueprint $table) {
            $table->renameColumn('responseTime', 'response_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_updates', function (Blueprint $table) {
            $table->renameColumn('response_time', 'responseTime');
        });
    }
}
