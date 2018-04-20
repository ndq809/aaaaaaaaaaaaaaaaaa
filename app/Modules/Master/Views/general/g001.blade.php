@extends('layout_master')
@section('title','Trang Cá Nhân')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-change-pass-dis','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/p003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Thống Kê Công Việc Của Bạn</h5>
	</div>
    <div class="panel-content no-padding-left">
    	<div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Thời Gian Tra Cứu</label>
                <div class="input-group picker">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" data-format="MM/yyyy" value="{{date('m/Y')}}" readonly="">
                    <span class="input-group-text">~</span>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" data-format="MM/yyyy" value="{{date('m/Y')}}" readonly="">
                </div>
            </div>
        </div>
    	 <div class="col-xs-12 no-padding-right show-on-click" click-btn="btn-list">
            <div class="table-fixed-width no-padding-left" min-width='1160px'>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hạng Mục Thao Tác</th>
                            <th>Nhóm Đã Tạo</th>
                            <th>Đã Phê Duyệt</th>
                            <th>Chưa Phê Duyệt</th>
                            <th>Thu Nhập Nhận Được</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1;$i<=5;$i++)
                        <tr>
                            <td>00{{$i}}</td>
                            <td>Từ Vựng</td>
                            <td>11 (1000 mục)</td>
                            <td>7 (800 mục)</td>
                            <td>4 (200 mục)</td>
                            <td>150,000 VND</td>
                        </tr>
                        @endfor
                        <tr>
                            <td colspan="5" class="text-right">Tổng Thu Nhập: </td>
                            <td>750,000 VND</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Thông Tin</h5>
    </div>
    <div class="panel-content no-padding-left update-content">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Thành Viên</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" value="TV001" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Đăng Nhập</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm required" value="Quy Nguyen" >
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Họ Tên</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm required" placeholder="Nhập mật khẩu mới">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="" class="form-control input-sm required" placeholder="Nhập email">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Số Điện Thoại</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm required" placeholder="Nhập số điện thoại">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Quyền Hạn</label>
                <select class="required">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Giới Tính</label>
                <select>
                    <option>Tất cả</option>
                </select>
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
        <div class="col-sm-12 no-padding-right">
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
<div class="panel main-panel col-xs-12">
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
</div>
@stop