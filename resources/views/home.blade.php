@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Links</div>

                <div class="panel-body">
                    <ul>
                    @if(Auth::user()->canAccess('dorgin.cheez.systems'))
                        <li><a href="https://dorgin.cheez.systems/sabnzbd">SabNZBD</a></li>
                        <li><a href="https://dorgin.cheez.systems/sabnzbd">Couch Potato</a></li>
                        <li><a href="https://dorgin.cheez.systems/sabnzbd">Sonarr</a></li>
                    @endif
                    @if(Auth::user()->canAccess('plex.cheez.systems'))
                        <li><a href="https://plex.cheez.systems/requests">Request new TV and Movies</a></li>
                        <li><a href="https://plex.cheez.systems/stats/dorgin">Dorgin Statistics</a></li>
                        <li><a href="https://plex.cheez.systems/stats/talyn">Talyn Statistics</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
