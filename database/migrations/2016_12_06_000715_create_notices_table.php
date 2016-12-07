<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notice_category_id')->unsigned();
            $table->foreign('notice_category_id')->references('id')->on('notice_categories');
            $table->string('title');
            $table->text('body');
            $table->boolean('active')->default(true);
            $table->timestamp('show_from')->nullable();
            $table->timestamp('show_to')->nullable();
            $table->index(['show_from']);
            $table->index(['show_to']);
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
        Schema::dropIfExists('notices');
    }
}
