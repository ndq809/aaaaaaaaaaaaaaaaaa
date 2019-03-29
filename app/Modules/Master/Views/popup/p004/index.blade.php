@extends('popup_master')
@section('title','Preview Bài Viết')
@section('asset_header')
	{!!WebFunctions::public_url('web-content/player/build/mediaelement-and-player.js')!!}
    {!!WebFunctions::public_url('web-content/player/build/renderers/facebook.js')!!}
    {!!WebFunctions::public_url('web-content/player/build/mediaelementplayer.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p004.css')!!}
    
@stop
@section('button')
{{Button::menu_button(array('btn-select','btn-edit','btn-refresh'))}}
@endsection
@section('content')
<div id="result" class="">
    @include('Master::popup.p004.search')
</div>
@stop