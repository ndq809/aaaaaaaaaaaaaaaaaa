@extends('layout_master')
@section('title','Thêm Quản Trị Viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/p002'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Quản Trị Viên</h5>
    </div>
    <div class="panel-content no-padding-left">
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
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Địa Chỉ</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Nhập địa chỉ">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm required">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm required" >
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
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox table-new-row">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Ngày Sinh</th>
                        <th>Giới Tính</th>
                        <th>Địa Chỉ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td>Quy Nguyen</td>
                        <td>Nguyễn Đình Quý</td>
                        <td>Quy809@gmail.com</td>
                        <td>0123456789</td>
                        <td>08/09/1993</td>
                        <td>Nam</td>
                        <td class="td-1-line">Tết tết tết tết đến rồi </td>
                        <td><a href="/master/v006" target="_blank"><span class="fa fa-anchor" style="padding-bottom: 2px;"></span> Cấp quyền</a></td>
                    </tr>
                    @for($i=1;$i<=5;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>00{{$i}}</td>
                        <td>Quy Nguyen</td>
                        <td>Nguyễn Đình Quý</td>
                        <td>Quy809@gmail.com</td>
                        <td>0123456789</td>
                        <td>08/09/1993</td>
                        <td>Nam</td>
                        <td class="td-1-line">Tết tết tết tết đến rồi </td>
                        <td><a href="/master/v006" target="_blank"><span class="fa fa-anchor" style="padding-bottom: 2px;"></span> Cấp quyền</a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop