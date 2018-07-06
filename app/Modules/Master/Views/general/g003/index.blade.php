@extends('layout_master')
@section('title','Quản Lý Danh Mục')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete','btn-save','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/general/g004'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Lọc Danh Sách</h5>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select id="catalogue_div" class=" submit-item allow-selectize ">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <div class="input-group">
                    <input id="catalogue_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên danh mục">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="result" class="panel main-panel col-xs-12">
    @include('Master::general.g003.search')
</div>
<div class="panel main-panel col-xs-12">
     <div class="panel-header padding-10-l">
        <h5 class="panel-title inline-block">Cập Nhật Thông Tin</h5>
        <a class="float-right edit-save"><span class="fa fa-hand-o-up"></span> Cập nhật sửa đổi</a>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Danh Mục</label>
                <div class="input-group">
                    <input id="catalogue_id" type="text" name="" class="form-control input-sm submit-item key-item" class="form-control input-sm" readonly="">
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select id="catalogue_div" class=" submit-item allow-selectize required">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <div class="input-group">
                    <input id="catalogue_nm" type="text" name="" class="form-control input-sm required submit-item" placeholder="Nhập tên danh mục">
                </div>
            </div>
        </div>
    </div>
</div>
@stop