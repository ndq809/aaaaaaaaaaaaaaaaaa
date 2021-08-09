@extends('layout_master')
@section('title','Import từ vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/vocabulary/v003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/vocabulary/v003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-execute','btn-save'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left update-block" id="result">
        @include('Master::vocabulary.v003.refer')
    </div>
</div>
@stop