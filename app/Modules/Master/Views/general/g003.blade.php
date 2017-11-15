@extends('layout_master')
@section('title','Thêm quản trị viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/v004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/v004.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/g002'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Quản Trị Viên</h5>
    </div>
    <div class="panel-content no-padding-left">
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
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Địa Chỉ</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" class="form-control input-sm" placeholder="Nhập địa chỉ">
                </div>
            </div>
        </div>
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
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Danh Sách Đã Thêm</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-xs-12"></div>
        <div class="col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox table-new-row">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Danh Mục</th>
                        <th>Nhóm</th>
                        <th>Phiên Âm</th>
                        <th>Nghĩa</th>
                        <th>Giải Thích</th>
                        <th>Hình Ảnh</th>
                        <th>Âm Thanh</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td>Abide by</td>
                        <td>600 từ vựng toleic</td>
                        <td>business</td>
                        <td>/ə'baid/</td>
                        <td>tôn trọng, tuân theo, giữ (lời)</td>
                        <td class="td-1-line">to accept and act according to a law, an agreement</td>
                        <td>Abide_by.jpg</td>
                        <td>Abide_by.mp3</td>
                    </tr>
                    @for($i=1;$i<=5;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>00{{$i}}</td>
                        <td>Abide by</td>
                        <td>600 từ vựng toleic</td>
                        <td>business</td>
                        <td>/ə'baid/</td>
                        <td>tôn trọng, tuân theo, giữ (lời)</td>
                        <td class="td-1-line">to accept and act according to a law, an agreement</td>
                        <td>Abide_by.jpg</td>
                        <td>Abide_by.mp3</td>
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