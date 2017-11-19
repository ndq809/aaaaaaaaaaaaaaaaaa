@extends('layout_master')
@section('title','Thêm mới danh mục')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/v002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/v002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-cancel','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/v002'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Danh Mục</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục Mới</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên danh mục cần tạo">
                </div>
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
                        <th>Tên Danh Mục</th>
                        <th width="123px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td><a href="/master/v003" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                    @for($i=1;$i<=2;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>00{{$i}}</td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td><a href="/master/v006" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop