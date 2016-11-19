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
        $dorginRole->save();

        $plexRole = new \App\Role();
        $plexRole->name = 'Accesses Plex';
        $plexRole->save();

        $link = new \App\DomainRole();
        $link->domain()->associate($dorgin);
        $link->role()->associate($dorginRole);
        $link->save();

        $link = new \App\DomainRole();
        $link->domain()->associate($plex);
        $link->role()->associate($plexRole);
        $link->save();
    }

}
