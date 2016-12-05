<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRoleIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->unique(['domain']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['code']);
            $table->unique(['code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropUnique(['domain']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->index(['code']);
        });
    }
}
