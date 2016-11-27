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

        $links = [
            [
                'name' => 'SabNZBD',
                'url' => 'https://dorgin.cheez.systems/sabnzbd',
                'icon_name' => 'sabnzbd.png',
                'description' => 'Usenet download client (actually does the downloading)',
                'category' => $tooling
            ],
            [
                'name' => 'Couch Potato',
                'url' => 'https://dorgin.cheez.systems/couchpotato',
                'icon_name' => 'couch.png',
                'description' => 'Manage and select movies to download',
                'category' => $tooling
            ],
            [
                'name' => 'Sonarr',
                'url' => 'https://dorgin.cheez.systems/sonarr',
                'icon_name' => 'sonarr.png',
                'description' => 'Manage and select TV shows to download',
                'category' => $tooling
            ],
            [
                'name' => 'Deluge',
                'url' => 'https://talyn.cheez.systems:8112',
                'icon_name' => 'deluge.png',
                'description' => 'Torrent download client (does downloading on the rare occasion we use torrents)',
                'category' => $tooling
            ],
            [
                'name' => 'Request new TV and Movies',
                'url' => 'https://plex.cheez.systems/requests',
                'icon_name' => 'requests.png',
                'description' => 'Request new TV shows and Movies be added to plex',
                'category' => $requests
            ],
            [
                'name' => 'Dorgin Statistics',
                'url' => 'https://plex.cheez.systems/stats/dorgin',
                'icon_name' => 'stats.png',
                'description' => 'Statistics for the Dorgin Plex server',
                'category' => $requests
            ],
            [
                'name' => 'Talyn Statistics',
                'url' => 'https://plex.cheez.systems/stats/talyn',
                'icon_name' => 'stats.png',
                'description' => 'Statistics for the Talyn Plex server',
                'category' => $requests
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
