<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceResponseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_response_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_update_id');
            $table->foreign('service_update_id')->references('id')->on('disks')->onDelete('cascade');
            $table->timestamp('entry_date');
            $table->unsignedBigInteger('response_time');
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
        Schema::dropIfExists('service_response_histories');
    }
}
