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
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://dorgin.cheez.systems/sabnzbd"><img src="{{ asset('images/sabnzbd.png') }}" />SabNZBD</a></li>
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://dorgin.cheez.systems/sabnzbd"><img src="{{ asset('images/couch.png') }}" />Couch Potato</a></li>
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://dorgin.cheez.systems/sabnzbd"><img src="{{ asset('images/sonarr.png') }}" />Sonarr</a></li>
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://talyn.cheez.systems:8112"><img src="{{ asset('images/deluge.png') }}"/>Deluge</a></li>
                        </ul>
                    </div>
                </div>
            @endif
            @if(Auth::user()->canAccess('plex.cheez.systems'))
                <div class="panel panel-default">
                    <div class="panel-heading">Requests</div>
                    <div class="panel-body">
                        <ul class="linkList">
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://plex.cheez.systems/requests"><img src="{{ asset('images/requests.png') }}"/>Request new TV and Movies</a></li>
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://plex.cheez.systems/stats/dorgin"><img src="{{ asset('images/stats.png') }}"/>Dorgin Statistics</a></li>
                            <li data-toggle="tooltip" data-placement="top" title=""><a href="https://plex.cheez.systems/stats/talyn"><img src="{{ asset('images/stats.png') }}"/>Talyn Statistics</a></li>
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