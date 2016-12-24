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
                        <table class="table table-bordered">
                            <tr>
                                <th>Service</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Since</th>
                                <th>Response Time</th>
                            </tr>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        <a href="{{ route('status.show', ['service' => $service]) }}">{{ $service->name }}</a>
                                    </td>
                                    <td>
                                        {{ $service->description }}
                                    </td>
                                    <td>
                                        {!! \App\ViewHelpers\StatusLabel::forStatus($service->last_update()->service_status) !!}
                                    </td>
                                    <td>
                                        <time class="timeago" datetime="{{ $service->last_update()->created_at->toIso8601String() }}">{{ $service->last_update()->created_at->toDateTimeString() }}</time>
                                    </td>
                                    <td>
                                        {{ $service->last_update()->response_time }} ms
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('time.timeago').timeago();
        });
    </script>
@endsection