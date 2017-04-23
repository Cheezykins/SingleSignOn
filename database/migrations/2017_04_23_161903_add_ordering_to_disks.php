<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderingToDisks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disks', function (Blueprint $table) {
            $table->dropIndex(['path']);
            $table->unique(['path']);
            $table->integer('order')->after('id')->default(1);
            $table->index(['order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disks', function (Blueprint $table) {
            $table->dropUnique(['path']);
            $table->index(['path']);
            $table->dropIndex(['order']);
            $table->dropColumn('order');
        });
    }
}
