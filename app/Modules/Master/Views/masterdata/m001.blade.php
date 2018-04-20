@extends('layout_master')
@section('title','Danh Sách Phòng Ban')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-change-pass-dis','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/p003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left">
    	<div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Từ Khóa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Từ khóa của từ vựng">
                </div>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header padding-10-l">
		<h5 class="panel-title">Danh Sách Phòng Ban</h5>
	</div>
	<div class="panel-content padding-10-l show-on-click" click-btn='btn-list'>
		<div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th width="100px">Mã Phòng Ban</th>
                        <th>Tên Phòng Ban</th>
                        <th>Tên Viết Tắt</th>
                        <th>Bộ Phận</th>
                        <th>Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                	@for($i=1;$i<=10;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="update-item">TV00{{$i}}</td>
                        <td class="update-item">Quy Nguyen</td>
                        <td class="update-role">Giám đốc</td>
                        <td class="update-item">Nguyen Quy</td>
                        <td class="update-item">quy@gmail.com</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        @if(!isset($paging))
            @php
                $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 100,'pageMax'=>10 )
            @endphp
        @endif
        @if($paging['totalRecord'] != 0)
            <div class=" text-center no-padding-left">
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
        <h5 class="panel-title">Cập Nhật Thông Tin</h5>
    </div>
    <div class="panel-content no-padding-left update-content">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Phòng Ban</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm disabled" value="Quy Nguyen" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Phòng Ban</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm required" placeholder="Nhập mật khẩu mới">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Viết Tắt</label>
                <div class="input-group">
                    <input type="email" name="" class="form-control input-sm" placeholder="Nhập email">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Bộ Phận</label>
                <div class="input-group">
                    <select>
                        <option>Phát triển</option>
                        <option>Chăm sóc khách hàng</option>
                        <option>Quản lý hệ thống</option>
                        <option>Ý tưởng</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Nhập số điện thoại">
                </div>
            </div>
        </div>
    </div>
    <div class=" col-xs-12 panel-bottom" >
        <ul class="pager mobile-pager">
            <li><a href="#">Hàng Trước</a></li>
            <li><a href="#">Hàng Tiếp</a></li>
        </ul>
    </div>
</div>
@stop