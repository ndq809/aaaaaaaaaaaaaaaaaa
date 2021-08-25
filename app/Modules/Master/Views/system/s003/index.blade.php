@extends('layout_master')
@section('title','Thêm Tài Khoản')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/system/s003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/system/s003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/system/s002'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Tài Khoản</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Tài Khoản</label>
                <div class="input-group">
                    <input id="account_id" type="text" name="" class="form-control input-sm identity-item" placeholder="Trường hệ thống tự sinh ra" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Nhân Viên</label>
                <div class="input-group">
                    <input data-refer="p002" id="employee_id" class="form-control input-sm input-refer submit-item" placeholder="Nhập mã nhân viên" > 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p002">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Hệ Thống</label>
                <select id="system_div" class="submit-item allow-selectize required">
                    @foreach($data[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Tài Khoản</label>
                <select id="account_div" class="submit-item allow-selectize required">
                    @foreach($data[1] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-sm-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Tài Khoản</label>
                <div class="input-group">
                    <input id="account_nm" type="text" name="" class="form-control input-sm submit-item required" placeholder="Nhập tên tài khoản">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu</label>
                <div class="input-group">
                    <input id="password" type="password" name="" class="form-control input-sm submit-item required" placeholder="Nhập mật khẩu" maxlength="50">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input id="password_confirm" type="password" name="" class="form-control input-sm submit-item required" placeholder="Nhập lại mật khẩu" maxlength="15">
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Chữ Ký</label>
                <div class="input-group">
                    <textarea id="signature" class="form-control input-sm submit-item" placeholder="Dùng để khai báo nguồn của bài đăng của bạn trên hệ thống" rows="4"></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú</label>
                <div class="input-group">
                    <textarea id="remark" class="form-control input-sm submit-item" placeholder="Ghi chú của tài khoản này" rows="4"></textarea>
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
                        <th>Mã Tài Khoản</th>
                        <th>Tên Tài Khoản</th>
                        <th>Nhân Viên</th>
                        <th>Loại Hệ Thống</th>
                        <th>Loại Tài Khoản</th>
                        <th>Chữ ký</th>
                        <th>Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td refer-id='account_id'></td>
                        <td refer-id='account_nm'></td>
                        <td refer-id='employee_id'></td>
                        <td refer-id='system_div'></td>
                        <td refer-id='account_div'></td>
                        <td refer-id='signature'></td>
                        <td refer-id='remark'></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop