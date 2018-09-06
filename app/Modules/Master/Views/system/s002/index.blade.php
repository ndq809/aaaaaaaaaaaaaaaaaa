@extends('layout_master')
@section('title','Danh Sách Tài Khoản')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/system/s002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/system/s002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete','btn-change-pass','btn-save','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/system/s003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
       <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Tài Khoản</label>
                <div class="input-group">
                    <input id="account_nm" type="text" name="" class="form-control input-sm submit-item " placeholder="Nhập tên tài khoản">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Nhân Viên</label>
                <div class="input-group">
                    <input data-refer="p002" id="employee_id" class="form-control input-sm input-refer submit-item " placeholder="Nhập mã nhân viên" > 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p002">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Hệ Thống</label>
                <select id="system_div_s" class="submit-item allow-selectize ">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Tài Khoản</label>
                <select id="account_div_s" class="submit-item allow-selectize ">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div id="result" class="panel main-panel col-xs-12">
	@include('Master::system.s002.search')
</div>
@if(Session::get('permission')['edit_per']==1)
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title inline-block">Cập Nhật Thông Tin</h5>
        <a class="float-right edit-save"><span class="fa fa-hand-o-up"></span> Cập nhật sửa đổi</a>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Tài Khoản</label>
                <div class="input-group">
                    <input id="account_id" type="text" name="" class="form-control input-sm key-item submit-item" placeholder="Trường hệ thống tự sinh ra" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Tài Khoản</label>
                <div class="input-group">
                    <input id="account_nm" type="text" name="" class="form-control input-sm submit-item required" placeholder="Nhập tên tài khoản">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Nhân Viên</label>
                <div class="input-group">
                    <input data-refer="p002" id="employee_id" class="form-control input-sm input-refer submit-item" placeholder="Nhập mã nhân viên" > 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p002">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-12"></div>

        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Hệ Thống</label>
                <select id="system_div" class="submit-item allow-selectize required">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Tài Khoản</label>
                <select id="account_div" class="submit-item allow-selectize required">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú</label>
                <div class="input-group">
                    <textarea id="remark" class="form-control input-sm submit-item" placeholder="Ghi chú của tài khoản này" rows="4"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop