@extends('layout')
@section('title','E+ Đăng Ký')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/croppic.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/croppic.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen/register.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/register.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
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
                <label>Ảnh Đại Diện</label>
                <div id="imageContainer" class="{{isset($default_data)?'isface':''}}"></div>
                <input type="hidden" class="submit-item" id="avatar" value="{{isset($default_data)?$default_data['avatar_original']:'/web-content/images/avarta/default_avarta.jpg'}}">
            </div>
            <div class="form-group">
                <label>Họ Tên Của Bạn</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control submit-item input-sm width-50" placeholder ="Họ" value="{{isset($default_data)?$default_data['first_nm']:''}}" id="first_name">
                    <input type="text" name="" class="form-control submit-item input-sm width-50" placeholder="Tên" value="{{isset($default_data)?$default_data['last_nm']:''}}" id="family_nm">
                </div>
            </div>
            <div class="form-group">
                <label>Tên Tài Khoản</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control submit-item input-sm" placeholder="Tên dùng để đăng nhập" value="{{isset($default_data)?$default_data['name']:''}}" id="account_nm_create">
                </div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control submit-item input-sm" placeholder="Mật khẩu" id="password_create">
                </div>
            </div>
            <div class="form-group width-50 inline-block float-left">
                <label>Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control submit-item input-sm" placeholder="Xác nhận mật khẩu" id="password_confirm">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="" class="form-control submit-item input-sm" placeholder="Nhập email của bạn" value="{{isset($default_data)?$default_data['email']:''}}" id="email">
                </div>
            </div>
		</div>
	</div>
    <div class="col-sm-6 col-xs-12 no-padding web-main main-content">
        <div class="example-header title-header">
            <span>Thông Tin Thêm !</span>
        </div>
        <div class="col-xs-12 main-content">
            <div class="col-xs-12 no-padding">
                <div class="form-group width-50 inline-block float-left">
                    <label>Ngày Sinh</label>
                    <div class="input-group picker">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="text" name="" class="form-control submit-item input-sm" data-field="date" placeholder="Ngày sinh của bạn" readonly="" id="birth_date">
                    </div>
                    <div id="dtBox" style="border: 1px solid #ddd;display: none;"></div>
                </div>
                <div class="form-group width-50 inline-block float-left">
                    <label>Giới Tính</label>
                    <select class="form-control submit-item input-sm" id="sex">
                        @foreach($data[0] as $index => $row)
                            <option value="{{$row['lib_cd']}}">{{$row['lib_nm']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <div class="form-group width-50 inline-block float-left">
                    <label>Nghề Nghiệp</label>
                    <select class="form-control submit-item input-sm" id="job">
                        @foreach($data[1] as $index => $row)
                            <option value="{{$row['lib_cd']}}">{{$row['lib_nm']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group width-50 inline-block float-left">
                    <label>Trình Độ Tiếng Anh</label>
                    <select class="form-control submit-item input-sm" id="eng_level">
                        @foreach($data[2] as $index => $row)
                            <option value="{{$row['lib_cd']}}">{{$row['lib_nm']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <div class="form-group width-50 inline-block float-left">
                    <label>Số Điện Thoại</label>
                    <div class="input-group">
                        <input type="text" name="" class="form-control numeric tel submit-item input-sm" placeholder="Nhập số điện thoại của bạn" value="" id="cellphone">
                    </div>
                </div>
                <div class="form-group width-50 inline-block float-left">
                    <label>Tỉnh/Thành Phố Hiện Tại</label>
                    <select class="form-control submit-item input-sm" id="position">
                        @foreach($data[3] as $index => $row)
                            <option value="{{$row['lib_cd']}}">{{$row['lib_nm']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <div class="form-group">
                    <label>Lĩnh Vực Quan Tâm</label>
                    <select class="margin-bottom custom-selectize submit-item" id="post_tag" multiple="multiple">
                        @foreach($data[4] as $index => $row)
                            <option value="{{$row['lib_cd']}}">{{$row['lib_nm']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <div class="form-group">
                    <label>Slogan Của Bạn</label>
                    <div class="input-group">
                        <textarea name="" class="form-control submit-item input-sm" rows="3" id="slogan"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <button class="btn btn-sm btn-primary col-xs-12 margin-top" type="button" id="btn-register">TRỞ THÀNH EPLUSER</button>
</div>

@stop

