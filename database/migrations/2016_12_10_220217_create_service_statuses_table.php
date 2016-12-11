<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('group');
            $table->timestamps();
        });

        \App\ServiceStatus::create(['status' => 'Unknown', 'group' => 'Neutral']);
        \App\ServiceStatus::create(['status' => 'Up', 'group' => 'Good']);
        \App\ServiceStatus::create(['status' => 'Down', 'group' => 'Bad']);
        \App\ServiceStatus::create(['status' => 'Pending: Up', 'group' => 'Warning']);
        \App\ServiceStatus::create(['status' => 'Pending: Down', 'group' => 'Warning']);
        \App\ServiceStatus::create(['status' => 'Up: Slow', 'group' => 'Warning']);
        \App\ServiceStatus::create(['status' => 'Up: Very Slow', 'group' => 'Bad']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_statuses');
    }
}
