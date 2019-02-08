@extends('layout')
@section('title','E+ Dịch Thuật')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/translation.js')!!}
    {!!WebFunctions::public_url('web-content/compromise/builds/compromise.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.highlight-within-textarea.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/jquery.highlight-within-textarea.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/translation.css')!!}
@stop
@section('left-tab')
    @include('User::translation.left_tab')
@stop
@section('content')
    @include('User::translation.main_content')
@stop

