<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefineBaseLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tooling = new \App\LinkCategory();
        $tooling->name = 'Tooling';
        $tooling->save();

        $requests = new \App\LinkCategory();
        $requests->name = 'Requests';
        $requests->save();

        $toolingRole = new \App\Role();
        $toolingRole->name = 'Can view tooling links';
        $toolingRole->code = 'VIEW_TOOLS';
        $toolingRole->save();

        $requestsRole = new \App\Role();
        $requestsRole->name = 'Can view requests links';
        $requestsRole->code = 'VIEW_REQUESTS';
        $requestsRole->save();


        $links = [
            [
                'name' => 'SabNZBD',
                'url' => 'https://dorgin.cheez.systems/sabnzbd',
                'icon_name' => 'sabnzbd.png',
                'description' => 'Usenet download client (actually does the downloading)',
                'category' => $tooling,
                'role' => $toolingRole
            ],
            [
                'name' => 'Couch Potato',
                'url' => 'https://dorgin.cheez.systems/couchpotato',
                'icon_name' => 'couch.png',
                'description' => 'Manage and select movies to download',
                'category' => $tooling,
                'role' => $toolingRole
            ],
            [
                'name' => 'Sonarr',
                'url' => 'https://dorgin.cheez.systems/sonarr',
                'icon_name' => 'sonarr.png',
                'description' => 'Manage and select TV shows to download',
                'category' => $tooling,
                'role' => $toolingRole
            ],
            [
                'name' => 'Deluge',
                'url' => 'https://talyn.cheez.systems:8112',
                'icon_name' => 'deluge.png',
                'description' => 'Torrent download client (does downloading on the rare occasion we use torrents)',
                'category' => $tooling,
                'role' => $toolingRole
            ],
            [
                'name' => 'Request new TV and Movies',
                'url' => 'https://plex.cheez.systems/requests',
                'icon_name' => 'requests.png',
                'description' => 'Request new TV shows and Movies be added to plex',
                'category' => $requests,
                'role' => $requestsRole
            ],
            [
                'name' => 'Dorgin Statistics',
                'url' => 'https://plex.cheez.systems/stats/dorgin',
                'icon_name' => 'stats.png',
                'description' => 'Statistics for the Dorgin Plex server',
                'category' => $requests,
                'role' => $requestsRole
            ],
            [
                'name' => 'Talyn Statistics',
                'url' => 'https://plex.cheez.systems/stats/talyn',
                'icon_name' => 'stats.png',
                'description' => 'Statistics for the Talyn Plex server',
                'category' => $requests,
                'role' => $requestsRole
            ]
        ];

        foreach ($links as $linkDetail)
        {
            $link = new \App\Link();
            $link->name = $linkDetail['name'];
            $link->url = $linkDetail['url'];
            $link->icon_name = $linkDetail['icon_name'];
            $link->description = $linkDetail['description'];
            $link->category()->associate($linkDetail['category']);
            $link->save();
            $link->roles()->attach($linkDetail['role']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
