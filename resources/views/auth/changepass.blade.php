@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/changepass') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('currentpass') ? ' has-error' : '' }}">
                            <label for="currentPassword" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="currentPassword" type="password" class="form-control" name="currentpass" required autofocus>

                                @if ($errors->has('currentpass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('currentpass') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('newpass') ? ' has-error' : '' }}">
                            <label for="newpass" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input pattern=".{10,}" id="newpass" type="password" class="form-control" name="newpass" required title="Minimum of 10 characters required">

                                @if ($errors->has('newpass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpass') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('confirmpass') ? ' has-error' : '' }}">
                            <label for="confirmpass" class="col-md-4 control-label">Confirm New Password</label>

                            <div class="col-md-6">
                                <input id="confirmpass" type="password" class="form-control" name="confirmpass" required>

                                @if ($errors->has('confirmpass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirmpass') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
