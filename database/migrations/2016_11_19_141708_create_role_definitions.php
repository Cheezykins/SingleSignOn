<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $plex = new \App\Domain();
        $plex->domain = 'plex.cheez.systems';
        $plex->save();
        $dorgin = new \App\Domain();
        $dorgin->domain = 'dorgin.cheez.systems';
        $dorgin->save();

        $dorginRole = new \App\Role();
        $dorginRole->name = 'Accesses Dorgin';
        $dorginRole->code = 'ACCESS_DORGIN';
        $dorginRole->save();
        $dorginRole->domains()->attach($dorgin->id);

        $plexRole = new \App\Role();
        $plexRole->name = 'Accesses Plex';
        $plexRole->code = 'ACCESS_PLEX';
        $plexRole->save();
        $plexRole->domains()->attach($plex->id);

        $all = new \App\Role();
        $all->name = 'Access All Domains';
        $all->code = 'ACCESS_ALL';
        $all->save();
        $all->domains()->attach([$dorgin->id, $plex->id]);

        $admin = new \App\Role();
        $admin->name = 'Administrator';
        $admin->code = 'ADMIN';
        $admin->save();
    }

    public function down()
    {

    }

}
