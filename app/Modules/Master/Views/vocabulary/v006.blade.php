@extends('layout_master')
@section('title','Thêm mới nhóm')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/v003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/v003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-cancel','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/v003'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Nhóm</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-lg-5 col-md-6 col-sm-8 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Nhóm</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-lg-5 col-md-6 col-sm-8 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm Mới</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên nhóm cần tạo">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='400px'>
            <table class="table table-hover table-bordered table-new-row table-checkbox">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Tên Nhóm</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td class="text-left">Business</td>
                        <td><a href="/master/v004" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm từ vựng</a></td>
                    </tr>
                    @for($i=1;$i<=2;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>00{{$i}}</td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td class="text-left">Business</td>
                        <td><a href="/master/v004" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm từ vựng</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop