@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Service Status
                    </div>
                    <div class="panel-body">
                        @foreach($serviceStatuses as $serviceStatus)
                            {!! \App\ViewHelpers\StatusLabel::alertFor($serviceStatus) !!}
                        @endforeach
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('status.index') }}">Details</a>
                    </div>
                </div>
                @foreach(Auth::user()->linksByCategory() as $category => $links)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $category }}</div>
                        <div class="panel-body">
                            <ul class="linkList">
                                @foreach ($links as $link)
                                    <li data-toggle="tooltip" data-placement="top" title="{{ $link->description }}">
                                        <a href="{{ $link->url }}">
                                            <img src="{{ asset('images/' . $link->icon_name) }}"/> {{ $link->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if($disks->count() > 0)
            <div class="row">
                @foreach($disks as $disk)
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">Disk Status: {{ $disk->path }}</div>
                            <div class="panel-body">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-info progress-striped"
                                         role="progressbar"
                                         aria-valuenow="{{ $disk->percentageUsed() }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100"
                                         style="width: {{ $disk->percentageUsed() }}%">
                                        {{ $disk->percentageUsed() }} % used
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Total Capacity</th>
                                        <td>{{ $disk->capacityFormatted() }}</td>
                                    </tr>
                                    <tr><th>Used</th><td> {{ $disk->usedSpaceFormatted() }}</td></tr>
                                    <tr><th>Free</th><td> {{ $disk->freeSpaceFormatted() }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        <!--
        jQuery(document).ready(function () {
            jQuery('[data-toggle="tooltip"]').tooltip();
        });
        //-->
    </script>
@endsection