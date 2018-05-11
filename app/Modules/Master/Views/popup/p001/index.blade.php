@extends('popup_master')
@section('title','Danh Sách Phòng Ban')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-refresh'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/p003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left">
    	<div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Từ Khóa</label>
                <div class="input-group">
                    <input type="text" id="department_nm" name="" class="form-control input-sm submit-item"  placeholder="Nhập tên phòng ban">
                </div>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div id="result" class="panel main-panel col-xs-12 ">
    @include('Master::popup.p001.search')
</div>
@stop