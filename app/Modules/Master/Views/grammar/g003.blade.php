@extends('layout_master')
@section('title','Quản Lý Nhóm Ngữ Pháp')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/grammar/g003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/grammar/g003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/v006'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Lọc Danh Sách</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Nhóm</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>600 từ vựng toleic</option>
                        <option>Tiếng anh IT</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 no-padding-right">
            <div class="form-group">
                <label>Từ Khóa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Nhập từ khóa">
                </div>
            </div>
        </div>
    </div>
    <div class="panel-bottom">
    </div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Danh Sách Nhóm</h5>
	</div>
    <div class="panel-content padding-10-l show-on-click" click-btn='btn-list'>
	   <div class="table-fixed-width no-padding-left" min-width='700px'>
            <table class="table table-hover table-bordered table-focus">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th width="100px">Mã Nhóm</th>
                        <th>Tên Danh Mục</th>
                        <th>Tên Nhóm</th>
                        <th width="100px">Số Ngữ Pháp</th>
                        <th width="120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1;$i<=15;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="text-left update-item">N00{{$i}}</td>
                        <td class="text-left update-item">
                            600 từ vựng toleic
                        </td>
                        <td class="text-left update-item">Business</td>
                        <td>23</td>
                        <td><a href="/master/g004" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm ngữ pháp</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        @if(!isset($paging))
            @php
                $paging=array('page' => 1,'pagesize' => 15,'totalRecord' => 100,'pageMax'=>10 )
            @endphp
        @endif
        @if($paging['totalRecord'] != 0)
            <div class=" text-center">
                {!!Paging::show($paging,0)!!}
            </div>
        @endif
    </div>
	<div class="panel-bottom">
     <i class="fa fa-spinner fa-spin"></i>   
    </div>
</div>
<div class="panel main-panel col-xs-12 show-on-click" click-btn="btn-list">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Nhóm</h5>
    </div>
    <div class="panel-content no-padding-left update-content">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Nhóm</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" value="DM001" readonly="">
                </div>
            </div>
        </div>
        <div class="col-md-3 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Nhóm</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>600 từ vựng toleic</option>
                        <option>Tiếng anh IT</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Cập nhật tên nhóm" value="Business">
                </div>
            </div>
        </div>
    </div>
    <div class=" col-xs-12 panel-bottom">
        <ul class="pager mobile-pager">
            <li><a href="#">Hàng Trước</a></li>
            <li><a href="#">Hàng Tiếp</a></li>
        </ul>
    </div>
</div>
@stop