@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Service</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('admin.services.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Service Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" value="{{ old('name') }}" class="form-control"
                                           name="name" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Service Description</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" value="{{ old('description') }}"
                                           class="form-control" name="description" required>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                <label for="active" class="col-md-4 control-label">Active</label>

                                <div class="col-md-6">
                                    <input id="active" type="checkbox" class="checkbox" name="active" checked>

                                    @if ($errors->has('active'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                <label for="url" class="col-md-4 control-label">Service URL</label>

                                <div class="col-md-6">
                                    <input id="url" type="url" class="form-control" name="url" value="{{ old('url') }}"
                                           required>

                                    @if ($errors->has('url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('url') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('method') ? ' has-error' : '' }}">
                                <label for="method" class="col-md-4 control-label">Request Method</label>

                                <div class="col-md-6">
                                    <select id="method" class="form-control" name="method">
                                        <option value="_none">Select a method</option>
                                        <option value="GET">GET</option>
                                        <option value="PUT">PUT</option>
                                        <option value="POST">POST</option>
                                        <option value="PATCH">PATCH</option>
                                        <option value="DELETE">DELETE</option>
                                    </select>

                                    @if ($errors->has('method'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('method') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('payload') ? ' has-error' : '' }}">
                                <label for="payload" class="col-md-4 control-label">Request Payload (optional)</label>

                                <div class="col-md-6">
                                    <textarea id="payload" class="form-control"
                                              name="payload">{{ old('payload') }}</textarea>

                                    @if ($errors->has('payload'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('payload') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('headers') ? ' has-error' : '' }}">
                                <label for="headers" class="col-md-4 control-label">Request Headers</label>

                                <div class="col-md-3">
                                    <input id="addHeaderKey" placeholder="Key" type="text" class="form-control">
                                </div>

                                <div class="input-group col-md-3">
                                    <input id="addHeaderValue" placeholder="Value" type="text" class="form-control">
                                    <span class="input-group-btn"><button id="buttonHeader"
                                                                          class="btn btn-success btn-add" type="button"
                                                                          onclick="addHeader();">+</button></span>
                                </div>

                                <div id="headers">
                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('query') ? ' has-error' : '' }}">
                                <label for="query" class="col-md-4 control-label">Request Query String</label>

                                <div class="col-md-3">
                                    <input id="addQueryKey" placeholder="Key" type="text" class="form-control">
                                </div>

                                <div class="input-group col-md-3">
                                    <input id="addQueryValue" placeholder="Value" type="text" class="form-control">
                                    <span class="input-group-btn"><button id="buttonQuery"
                                                                          class="btn btn-success btn-add" type="button"
                                                                          onclick="addQuery();">+</button></span>
                                </div>

                                <div id="query">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('slow_threshold') ? ' has-error' : '' }}">
                                <label for="slow_threshold" class="col-md-4 control-label">Service Slow
                                    Threshold</label>

                                <div class="col-md-6">
                                    <input id="slow_threshold" type="text" value="{{ old('slow_threshold') }}"
                                           class="form-control" name="slow_threshold" required pattern="[0-9]+">

                                    @if ($errors->has('slow_threshold'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('slow_threshold') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('very_slow_threshold') ? ' has-error' : '' }}">
                                <label for="very_slow_threshold" class="col-md-4 control-label">Service Very Slow
                                    Threshold</label>

                                <div class="col-md-6">
                                    <input id="very_slow_threshold" type="text" value="{{ old('very_slow_threshold') }}"
                                           class="form-control" name="very_slow_threshold" required>

                                    @if ($errors->has('very_slow_threshold'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('very_slow_threshold') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="history.go(-1)">
                                        Cancel
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
