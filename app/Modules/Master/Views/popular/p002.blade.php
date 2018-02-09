@extends('layout_master')
@section('title','Danh Sách Quản Trị Viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/popular/p002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/popular/p002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-change-pass-dis','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/g003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left">
    	<div class="col-sm-3 no-padding-right">
    	    <div class="form-group">
    	        <label>Quyền</label>
    	        <div class="input-group">
    	            <select class="form-control input-sm">
    	                <option>this is select box</option>
    	            </select>
    	        </div>
    	    </div>
    	</div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Quản Trị</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
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
		<h5 class="panel-title">Danh Sách Quản Trị Viên</h5>
	</div>
	<div class="panel-content padding-10-l show-on-click" click-btn='btn-list'>
		<div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th width="100px">Mã Thành Viên</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Quyền</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th width="120px">Số Điện Thoại</th>
                        <th>Giới Tính</th>
                        <th width="150px">Ngày Sinh</th>
                        <th>Địa Chỉ</th>
                    </tr>
                </thead>
                <tbody>
                	@for($i=1;$i<=10;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="update-item">TV00{{$i}}</td>
                        <td class="update-item">Quy Nguyen</td>
                        <td class="update-role btn-link btn-popup" popup-id='popup-box0'>178</td>
                        <td class="update-item">Nguyen Quy</td>
                        <td class="update-item">quy@gmail.com</td>
                        <td class="update-item">0123456789</td>
                        <td class="update-item"> Nam </td>
                        <td class="update-item"> 05/12/2017 </td>
                        <td class="td-1-line update-item">k94/56 lê hữu trác sơn trà đà nẵng</td>                        
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <ul class="pager">
            <li><a href="#">Trước</a></li>
            <li>
                <select class="form-control input-sm" style="width: 100px;display: inline-block;">
                    <option>this is select box</option>
                </select>
            </li>
            <li><a href="#">Tiếp</a></li>
        </ul>
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
                <label>Mã Thành Viên</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" value="TV001" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Đăng Nhập</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" value="Quy Nguyen" >
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Họ Tên</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Nhập mật khẩu mới">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Nhập email">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Số Điện Thoại</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Nhập số điện thoại">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Giới Tính</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>Nam</option>
                        <option>Nữ</option>
                        <option>Khác</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Ngày Sinh</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" placeholder="this is Datepicker">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Địa Chỉ</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Nhập địa chỉ">
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
<div class="panel main-panel col-xs-12 show-on-click" click-btn="btn-list">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Mật Khẩu</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu Mới</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm" class="form-control input-sm">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Xác Nhận Mật Khẩu Mới</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm" class="form-control input-sm">
                </div>
            </div>
        </div>
</div>
@stop