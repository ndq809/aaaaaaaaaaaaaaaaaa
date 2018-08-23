@extends('layout_master')
@section('title','Thêm Mới Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/vocabulary/v002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/vocabulary/v002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save','btn-upgrade','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/vocabulary/v001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left update-block" id="result">
        @include('Master::vocabulary.v002.refer')
    </div>
</div>
@stop