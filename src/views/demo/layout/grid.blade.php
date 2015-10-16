@extends('bees::demo.layout.master')

@section('variations')
    <ul class="nav nav-pills">
        {{ $demo->activeLink('Tacone\Bees\Demo\Controllers\GridController@anyIndex', 'Simple') }}
        {{ $demo->activeLink('Tacone\Bees\Demo\Controllers\GridController@anyCallback', 'Callbacks') }}
    </ul>
@stop
