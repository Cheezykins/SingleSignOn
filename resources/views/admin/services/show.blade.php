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
                                <td>@include('partials._boolean', ['item' => $service->active])</td>
                            </tr>
                            <tr>
                                <th>Request URL</th>
                                <td>{{ $service->url }}</td>
                            </tr>
                            <tr>
                                <th>Validate SSL Certificate</th>
                                <td>@include('partials._boolean', ['item' => $service->enable_ssl_validation])</td>
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
                <div class="panel panel-default">
                    <div class="panel-heading">Service History</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Response Time</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($service->service_updates()->orderBy('created_at', 'DESC')->get() as $update)
                                <tr>
                                    <td>{{ $update->created_at->toDateTimeString() }}</td>
                                    <td>{!! \App\ViewHelpers\StatusLabel::forStatus($update->service_status) !!}</td>
                                    <td>{{ $update->response_time }}</td>
                                    <td>
                                        @if (strlen(trim($update->log)) > 0)
                                            <button onclick="toggleLog(this)" class="btn btn-primary">Show / Hide Log</button>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="logContainer">
                                    <td colspan="4"><div style="width: 100%"><div class="log">{{ $update->log }}</div></div></td>
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
        function toggleLog(node)
        {
            $(node).closest('tr').next().slideToggle();
        }
    </script>
@endsection