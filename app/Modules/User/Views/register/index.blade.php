@extends('layout')
@section('title','E+ Đăng Ký')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/croppic.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/croppic.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen/register.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/register.css')!!}
@stop

@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="fa fa-hand-grab-o"></i> ĐĂNG KÝ TRỞ THÀNH EPLUSER</h5>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12 no-padding web-main main-content">
        <div class="example-header title-header">
            <span>Thông Tin Bắt Buộc !</span>
        </div>
		<div class="col-xs-12 main-content">
            <div class="form-group">
                <label>Họ Tên Của Bạn</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm width-50" placeholder ="Họ">
                    <input type="text" name="" class="form-control input-sm width-50" placeholder="Tên">
                </div>
            </div>
            <div class="form-group">
                <label>Tên Tài Khoản</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên dùng để đăng nhập">
                </div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm" placeholder="Mật khẩu">
                </div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm" placeholder="Xác nhận mật khẩu">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="" class="form-control input-sm" placeholder="Nhập email của bạn">
                </div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Ngày Sinh</label>
                <div class="input-group picker">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" placeholder="Ngày sinh của bạn" readonly="">
                </div>
                <div id="dtBox" style="border: 1px solid #ddd;"></div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Giới Tính</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ảnh Đại Diện</label>
                <div id="imageContainer"></div>
            </div>
		</div>
	</div>
    <div class="col-sm-6 col-xs-12 no-padding web-main main-content">
        <div class="example-header title-header">
            <span>Thông Tin Thêm !</span>
        </div>
        <div class="col-xs-12 main-content">
            <div class="form-group width-50 inline-block float-left">
                <label>Nghề Nghiệp</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Trình Độ Tiếng Anh</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Slogan Của Bạn</label>
                <div class="input-group">
                    <textarea name="" class="form-control input-sm" rows="3"></textarea>
                </div>
            </div>
        </div>
        
    </div>
</div>
<button class="btn btn-sm btn-primary col-xs-12 margin-top" type="button">TRỞ THÀNH EPLUSER</button>

@stop

