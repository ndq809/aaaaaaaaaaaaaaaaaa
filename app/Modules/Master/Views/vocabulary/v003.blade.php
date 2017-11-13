@extends('layout_master')
@section('title','Quản lý nhóm')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/v003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/v003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save','btn-delete','btn-cancel','btn-print'))}}
@endsection
@section('content')
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
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-danger" id="btn-new-row"><span class="fa fa-plus"></span> Thêm Nhóm</button>
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
                        <th>Tên Nhóm</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><button class="btn btn-sm btn-warning delete-tr-row"><i class="fa fa-remove"></i></button></td>
                        <td></td>
                        <td class="text-left">600 từ vựng toleic</td>
                        <td class="text-left">Business</td>
                        <td><a href="/master/v004" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm từ vựng</a></td>
                    </tr>
                    @for($i=1;$i<=2;$i++)
                    <tr>
                        <td><button class="btn btn-sm btn-warning delete-tr-row"><i class="fa fa-remove"></i></button></td>
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
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Quản Lý Nhóm</h5>
	</div>
    <div class="panel-content padding-10-l">
	   <div class="table-fixed-width no-padding-left" min-width='700px'>
            <table class="table table-hover table-bordered update-table">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th width="100px">Mã Nhóm</th>
                        <th>Tên Danh Mục</th>
                        <th>Tên Nhóm</th>
                        <th width="100px">Số Từ Vựng</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1;$i<=20;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="text-left">N00{{$i}}</td>
                        <td class="text-left">
                            <select class="form-control input-sm">
                                <option>600 từ vựng toleic</option>
                                <option>Tiếng anh IT</option>
                            </select>
                        </td>
                        <td class="text-left"><input type="text" name="" class="form-control input-sm" value="Business"></td>
                        <td>23</td>
                        <td><a href="/master/v004" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm từ vựng</a></td>
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