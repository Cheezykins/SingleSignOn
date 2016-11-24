@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Auth::user()->canAccess('dorgin.cheez.systems'))
                <div class="panel panel-default">
                    <div class="panel-heading">Tooling Links</div>
                    <div class="panel-body">
                        <ul class="linkList">
                            <li data-toggle="tooltip" data-placement="top" title="Usenet download client (actually does the downloading)"><a href="https://dorgin.cheez.systems/sabnzbd"><img src="{{ asset('images/sabnzbd.png') }}" />SabNZBD</a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Manage and select movies to download"><a href="https://dorgin.cheez.systems/couchpotato"><img src="{{ asset('images/couch.png') }}" />Couch Potato</a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Manage and select TV shows to download"><a href="https://dorgin.cheez.systems/sonarr"><img src="{{ asset('images/sonarr.png') }}" />Sonarr</a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Torrent download client (does downloading on the rare occasion we use torrents)"><a href="https://talyn.cheez.systems:8112"><img src="{{ asset('images/deluge.png') }}"/>Deluge</a></li>
                        </ul>
                    </div>
                </div>
            @endif
            @if(Auth::user()->canAccess('plex.cheez.systems'))
                <div class="panel panel-default">
                    <div class="panel-heading">Requests</div>
                    <div class="panel-body">
                        <ul class="linkList">
                            <li data-toggle="tooltip" data-placement="top" title="Request new TV shows and Movies be added to plex"><a href="https://plex.cheez.systems/requests"><img src="{{ asset('images/requests.png') }}"/>Request new TV and Movies</a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Statistics for the Dorgin Plex server"><a href="https://plex.cheez.systems/stats/dorgin"><img src="{{ asset('images/stats.png') }}"/>Dorgin Statistics</a></li>
                            <li data-toggle="tooltip" data-placement="top" title="Statistics for the Talyn Plex server"><a href="https://plex.cheez.systems/stats/talyn"><img src="{{ asset('images/stats.png') }}"/>Talyn Statistics</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        <!--
            jQuery(document).ready(function() {
                jQuery('[data-toggle="tooltip"]').tooltip();
            });
        //-->
    </script>
@endsection