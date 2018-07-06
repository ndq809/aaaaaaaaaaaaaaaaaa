@extends('layout_master')
@section('title','Thêm Mới Danh Mục Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g004.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/general/g003'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Danh Mục</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Danh Mục</label>
                <div class="input-group">
                    <input id="catalogue_id" type="text" name="" class="form-control input-sm identity-item" placeholder="Trường hệ thống tự sinh ra" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select id="catalogue_div" class="submit-item allow-selectize required">
                    @foreach($data[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục Mới</label>
                <select id="catalogue_nm" class="submit-item new-allow allow-selectize required" placeholder="Lưu ý: Thêm giá trị ngoài danh sách bên dưới">
                        <option value=""></option>
                </select>
            </div>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Danh Sách Đã Thêm</h5>
    </div>
    <div class="panel-content padding-10-l">
        <div class="table-fixed-width no-padding-left" min-width='380px'>
            <table class="table table-hover table-bordered table-new-row table-checkbox">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th>Mã Danh Mục</th>
                        <th>Loại Danh Mục</th>
                        <th>Tên Danh Mục</th>
                        <th width="123px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td refer-id='catalogue_id'></td>
                        <td refer-id='catalogue_div'></td>
                        <td refer-id='catalogue_nm' class="text-left"></td>
                        <td><a href="/master/general/g006" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop