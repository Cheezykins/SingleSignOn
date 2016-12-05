<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('user_default')->default(false)->after('code');
        });

        $plexRole = \App\Role::whereCode('ACCESS_PLEX')->first();
        $viewRole = \App\Role::whereCode('VIEW_REQUESTS')->first();

        $plexRole->user_default = true;
        $plexRole->save();
        $viewRole->user_default = true;
        $viewRole->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->removeColumn('user_default');
        });
    }
}
