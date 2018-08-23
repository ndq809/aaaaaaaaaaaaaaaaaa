@extends('popup_master')
@section('title','Preview Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p004.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-edit','btn-delete'))}}
@endsection
@section('content')
<div id="result" class="">
    @include('Master::popup.p004.search')
</div>
@stop