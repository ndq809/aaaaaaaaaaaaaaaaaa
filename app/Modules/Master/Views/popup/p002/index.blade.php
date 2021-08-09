@extends('popup_master')
@section('title','Danh Sách Nhân Viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popup/p002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popup/p002.css')!!}
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
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Họ Và tên Lót</label>
                <div class="input-group">
                    <input id="family_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập họ và tên lót" maxlength="50">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên</label>
                <div class="input-group">
                    <input id="first_name" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên" maxlength="20">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Phòng Ban</label>
                <div class="input-group">
                    <input data-refer="p001" id="department_id" class="form-control input-sm input-refer submit-item" placeholder="Nhập mã phòng ban"> 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p001">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Nhân Viên</label>
                <select id="employee_div" class="submit-item allow-selectize">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div id="result" class="panel main-panel col-xs-12 ">
    @include('Master::popup.p002.search')
</div>
@stop