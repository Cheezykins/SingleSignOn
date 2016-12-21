<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiskHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disk_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('disk_id');
            $table->foreign('disk_id')->references('id')->on('disks')->onDelete('cascade');
            $table->timestamp('entry_date');
            $table->unsignedBigInteger('capacity');
            $table->unsignedBigInteger('free_space');
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
        Schema::dropIfExists('disk_histories');
    }
}
