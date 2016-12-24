@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Service History</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Response Time</th>
                            </tr>
                            @foreach ($service->service_updates()->orderBy('created_at', 'DESC')->get() as $update)
                                <tr>
                                    <td>{{ $update->created_at->toDateTimeString() }}</td>
                                    <td>{!! \App\ViewHelpers\StatusLabel::forStatus($update->service_status) !!}</td>
                                    <td>{{ $update->response_time }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection