@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $service->name }}</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $service->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $service->description }}</td>
                            </tr>
                            <tr>
                                <th>Active</th>
                                <td>{{ $service->active }}</td>
                            </tr>
                            <tr>
                                <th>Request URL</th>
                                <td>{{ $service->url }}</td>
                            </tr>
                            <tr>
                                <th>Request method</th>
                                <td>{{ $service->method }}</td>
                            </tr>
                            <tr>
                                <th>Request payload</th>
                                <td>{{ $service->payload }}</td>
                            </tr>
                            <tr>
                                <th>Request headers</th>
                                <td>
                                    <ul>
                                        @foreach($service->service_headers as $param)
                                            <li><strong>{{ $param->key }}:</strong> {{ $param->value }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Request Query String Parameters</th>
                                <td>
                                    <ul>
                                        @foreach($service->service_query_parameters as $param)
                                            <li><strong>{{ $param->key }}:</strong> {{ $param->value }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>Slow Threshold</th>
                                <td>{{ $service->slow_threshold }}</td>
                            </tr>
                            <tr>
                                <th>Very Slow Threshold</th>
                                <td>{{ $service->very_slow_threshold }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection