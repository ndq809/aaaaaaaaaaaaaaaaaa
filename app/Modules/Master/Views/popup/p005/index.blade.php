@extends('popup_master')
@section('title','Danh Sách Bài Học')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p005.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p005.css')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/imagepreview.js')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-save','btn-refresh'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select id="catalogue_nm" class="submit-item allow-selectize required">
                        <option value=""></option>
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm" class="submit-item allow-selectize required">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Tên Bài Viết</label>
                <div class="input-group">
                    <input id="vocabulary_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên từ vựng" maxlength="50">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel main-panel col-xs-12 ">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Danh Sách Bài Học</h5>
    </div>
    <div class="panel-content padding-10-l" id="result" >
        @include('Master::popup.p005.search')
    </div>
</div>
<div class="panel main-panel col-xs-12 ">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Danh Sách Được Chọn</h5>
    </div>
    <div class="panel-content padding-10-l" id="result1">
        @include('Master::popup.p005.select')
    </div>
</div>
@stop