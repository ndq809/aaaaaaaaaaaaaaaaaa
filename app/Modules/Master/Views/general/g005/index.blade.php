@extends('layout_master')
@section('title','Quản Lý Nhóm Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g005.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g005.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete','btn-save','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/general/g006'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Lọc Danh Sách</h5>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select class="allow-selectize submit-item" id="catalogue_div_s">
                     @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select class="submit-item allow-selectize new-allow" id="catalogue_nm_s">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm_s" class="submit-item new-allow allow-selectize">
                        <option value=""></option>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="result" class="panel main-panel col-xs-12">
	@include('Master::general.g005.search')
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title inline-block">Cập Nhật Thông Tin</h5>
        <a class="float-right edit-save"><span class="fa fa-hand-o-up"></span> Cập nhật sửa đổi</a>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Nhóm</label>
                <div class="input-group">
                    <input id="group_id" type="text" name="" class="form-control input-sm submit-item key-item" class="form-control input-sm" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select class="submit-item allow-selectize required" id="catalogue_div">
                     @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select class="submit-item allow-selectize required" id="catalogue_nm">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm" class="submit-item new-allow get-text required allow-selectize" placeholder="Lưu ý: Sửa với giá trị ngoài danh sách bên dưới">
                        <option value=""></option>
                </select>
            </div>
        </div>
    </div>
</div>
@stop