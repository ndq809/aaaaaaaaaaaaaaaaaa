@extends('popup_master')
@section('title','Danh Sách Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p003.css')!!}
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
                <label>Loại Từ Vựng</label>
                <select id="vocabulary_div" class="submit-item">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Từ Vựng</label>
                <div class="input-group">
                    <input id="vocabulary_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên từ vựng" maxlength="50">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nghĩa Từ Vụng</label>
                <div class="input-group">
                    <input id="mean" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập nghĩa từ vựng" maxlength="200">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel main-panel col-xs-12 ">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Danh Sách Từ Vựng</h5>
    </div>
    <div class="panel-content padding-10-l" id="result" >
        @include('Master::popup.p003.search')
    </div>
</div>
<div class="panel main-panel col-xs-12 ">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Danh Sách Được Chọn</h5>
    </div>
    <div class="panel-content padding-10-l" id="result1">
        @include('Master::popup.p003.select')
    </div>
</div>
@stop