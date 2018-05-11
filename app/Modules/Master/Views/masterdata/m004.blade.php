@extends('layout_master')
@section('title','Thêm Nhân Viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m004.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/data/m003'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Nhân Viên</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Họ Và tên Lót</label>
                <div class="input-group">
                    <input id="family_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập họ và tên lót" maxlength="50">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên</label>
                <div class="input-group">
                    <input id="first_name" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên" maxlength="20">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input id="email" type="email" name="" class="form-control input-sm submit-item" placeholder="Nhập email" maxlength="50">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Số Điện Thoại</label>
                <div class="input-group">
                    <input id="cellphone" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập số điện thoại" maxlength="15">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Giới Tính</label>
                <select id="sex" class="submit-item">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Ngày Sinh</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input id="birth_date" type="text" name="" class="form-control input-sm submit-item" data-field="date" placeholder="this is Datepicker">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Phòng Ban</label>
                <div class="input-group">
                    <input class="form-control input-sm" placeholder="Search for..." > 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p001">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Nhân Viên</label>
                <select class="required submit-item" id="employee_div">
                    <option> </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 no-padding-right">
            <div class="form-group old-item">
                <label>Hình Ảnh Mặc Định</label>
                <div class="input-group file-subitem">
                    <img src="/web-content/images/avarta/avarta.jpg">
                </div>
            </div>
            <div class="form-group new-item">
                <label class="invisible">.</label>
                <div class="input-group file-subitem">
                    <input type="file" class="input-image" name=""  value="">
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú</label>
                <div class="input-group">
                    <textarea id="remark" class="form-control input-sm submit-item" placeholder="Nhập địa chỉ" rows="7"></textarea>
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
         <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Đăng Nhập</label>
                <div class="input-group">
                    <input id="account_nm" type="text" name="" class="form-control input-sm required submit-item" placeholder="Nhập tên tài khoản" >
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu</label>
                <div class="input-group">
                    <input id="password" type="password" name="" class="form-control input-sm required submit-item" maxlength="100" placeholder="Nhập mật khẩu">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input id="password_confirm" type="password" name="" class="form-control input-sm required submit-item" maxlength="100" placeholder="Xác nhận lại mật khẩu đã nhập">
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
                        <th>Quyền</th>
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
                        <td>Giám đốc</td>
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
                        <td>Giám đốc</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop