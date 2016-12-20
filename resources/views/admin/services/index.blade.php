@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Services</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Service ID</th>
                                <th>Name</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td><a href="{{ route('admin.services.show', ['service' => $service]) }}">{{ $service->id }}</a></td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->active }}</td>
                                    <td>
                                        <a href="{{ route('admin.services.show', ['service' => $service]) }}">View</a> /
                                        <a href="{{ route('admin.services.edit', ['service' => $service]) }}">Edit</a> /
                                        <a href="#"
                                           onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form" action="{{ route('admin.services.destroy', ['service' => $service]) }}" method="POST" style="display: none;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('admin.services.create') }}">Create new service</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection