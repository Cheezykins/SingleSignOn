@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User: {{ $user->username }}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.users.update', ['user' => $user]) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">User Name</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" value="{{ $user->username }}" class="form-control" name="username" pattern="[a-zA-Z0-9-_]{2,}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                                <label for="roles" class="col-md-4 control-label">Roles</label>

                                <div class="col-md-6">
                                    <select id="roles" class="form-control" name="roles" multiple>
                                        @foreach(\App\Role::all() as $role)
                                            <option value="{{ $role->id }}" @if($user->hasRole($role->code))selected @endif>
                                                {{ $role->code }} - {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('roles'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('roles') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection