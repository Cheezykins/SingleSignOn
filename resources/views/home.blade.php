@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @foreach(Auth::user()->linksByCategory() as $category => $links)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $category }}</div>
                    <div class="panel-body">
                        <ul class="linkList">
                            @foreach ($links as $link)
                                <li data-toggle="tooltip" data-placement="top" title="{{ $link->description }}">
                                    <a href="{{ $link->url }}">
                                        <img src="{{ asset('images/' . $link->icon_name) }}" /> {{ $link->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        <!--
            jQuery(document).ready(function() {
                jQuery('[data-toggle="tooltip"]').tooltip();
            });
        //-->
    </script>
@endsection