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
    <div class="panel-content no-padding-left update-block">
        <div class="no-padding avarta-block">
            <div class="col-sm-12 no-padding-right padding-left-10">
                <div class="form-group old-item">
                    <label>Hình Ảnh Mặc Định</label>
                    <div id="imageContainer"></div>
                </div>
                <input type="hidden" class="submit-item" name="avarta" id="avarta" value="/web-content/images/avarta/default_avarta.jpg">
            </div>
        </div>
        <div class="no-padding infor-block" >
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Mã Nhân Viên</label>
                    <div class="input-group">
                        <input id="emp_id" type="text" name="" class="form-control input-sm identity-item" placeholder="Trường hệ thống tự sinh ra" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
               <div class="form-group">
                    <label>Họ Và Tên</label>
                    <div class="input-group">
                        <input type="text" id="family_nm" name="" class="form-control input-sm width-50 submit-item" placeholder="Họ và tên lót">
                        <input type="text" id="first_name" name="" class="form-control input-sm width-50 submit-item" placeholder="Tên">
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
                        @foreach($data[0] as $item)
                            <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Ngày Sinh</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input id="birth_date" type="text" name="" class="form-control input-sm submit-item" data-field="date" placeholder="Chọn ngày sinh">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Phòng Ban</label>
                    <div class="input-group">
                        <input data-refer="p001" id="department_id" class="form-control input-sm input-refer submit-item" placeholder="Nhập mã phòng ban" > 
                        <span class="input-group-btn"> 
                            <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p001">Tìm Kiếm</a> 
                        </span> 
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Loại Nhân Viên</label>
                    <select id="employee_div" class="submit-item allow-selectize required">
                        @foreach($data[1] as $item)
                            <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 no-padding-right">
                <div class="form-group">
                    <label>Ghi Chú</label>
                    <div class="input-group">
                        <textarea id="remark" class="form-control input-sm submit-item" placeholder="Ghi chú của nhân viên này" rows="4"></textarea>
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
    <div class="panel-content padding-10-l">
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox table-new-row">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Mã Nhân Viên</th>
                        <th>Họ Và tên Lót</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Bộ Phận</th>
                        <th>Loại Nhân Viên</th>
                        <th>Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td refer-id='emp_id'></td>
                        <td refer-id='family_nm'></td>
                        <td refer-id='first_name'></td>
                        <td refer-id='email'></td>
                        <td refer-id='sex'></td>
                        <td refer-id='birth_date'></td>
                        <td refer-id='department_id' class="td-1-line"></td>
                        <td refer-id='employee_div' class="td-1-line"></td>
                        <td refer-id='remark'></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop