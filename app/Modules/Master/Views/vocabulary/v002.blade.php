@extends('layout_master')
@section('title','Quản lý danh mục')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/v002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/v002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save','btn-delete','btn-cancel','btn-print'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Danh Mục</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-lg-5 col-md-6 col-sm-8 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục Mới</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên danh mục cần tạo">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-danger" id="btn-new-row"><span class="fa fa-plus"></span> Thêm Danh Mục</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='400px'>
            <table class="table table-hover table-bordered new-row-table">
                <thead>
                    <tr>
                        <th width="50px">Xóa</th>
                        <th width="50px">ID</th>
                        <th>Tên Danh Mục</th>
                        <th width="123px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><button class="btn btn-sm btn-warning delete-tr-row"><i class="fa fa-remove"></i></button></td>
                        <td></td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td><a href="/master/v003" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                    @for($i=1;$i<=2;$i++)
                    <tr>
                        <td><button class="btn btn-sm btn-warning delete-tr-row"><i class="fa fa-remove"></i></button></td>
                        <td>00{{$i}}</td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td><a href="/master/v003" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Quản Lý Danh Mục</h5>
	</div>
    <div class="panel-content padding-10-l">
	   <div class="table-fixed-width no-padding-left" min-width='700px'>
            <table class="table table-hover table-bordered update-table">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th width="100px">Mã Danh Mục</th>
                        <th>Tên Danh Mục</th>
                        <th width="100px">Số Nhóm</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1;$i<=20;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="text-left">DM00{{$i}}</td>
                        <td class="text-left"><input type="text" name="" class="form-control input-sm" value="600 từ vựng toleic"></td>
                        <td>23</td>
                        <td><a href="/master/v003" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm nhóm</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <ul class="pager">
            <li><a href="#">Đầu</a></li>
            <li><a href="#">Trước</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">...</a></li>
            <li><a href="#">17</a></li>
            <li><a href="#">Tiếp</a></li>
            <li><a href="#">Cuối</a></li>
        </ul>
    </div>
	<div class="panel-bottom"></div>
</div>
@stop