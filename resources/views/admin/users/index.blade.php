@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td><a href="{{ route('admin.users.show', ['user' => $user]) }}">{{ $user->id }}</a></td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            <ul>
                                                @foreach($user->roles as $role)
                                                    <li>{{ $role->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.show', ['user' => $user]) }}">View</a> /
                                            <a href="{{ route('admin.users.edit', ['user' => $user]) }}">Edit</a> /
                                            @if (Auth::user()->id == $user->id)
                                                Reset Password / Delete

                                            @else
                                                <a href="#" onclick="event.preventDefault();document.getElementById('reset-form-{{ $user->id }}').submit()">Reset Password</a> /
                                                <a href="#" onclick="event.preventDefault();document.getElementById('delete-form-{{ $user->id }}').submit()">Delete</a>
                                            @endif

                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="POST" style="display: none;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                            </form>

                                            <form id="reset-form-{{ $user->id }}" action="{{ route('admin.users.resetpassword', ['user' => $user]) }}" method="POST" style="display: none;">
                                                <input type="hidden" name="_method" value="PUT">
                                                {{ csrf_field() }}
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('admin.users.create') }}">Create new user</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection