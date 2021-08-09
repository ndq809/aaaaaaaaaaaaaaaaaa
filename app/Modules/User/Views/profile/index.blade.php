@extends('layout')
@section('title','E+ Trang Cá Nhân')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/croppic.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/croppic.css')!!}
    {!!WebFunctions::public_url('web-content/chart/dist/jquery.charts.js')!!}
    {!!WebFunctions::public_url('web-content/chart/dist/utils.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/profile.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/profile.css')!!}
@stop
@section('left-tab')
    @include('User::profile.left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
    <div class="col-md-12 no-padding">
        <div class="right-header">
            <h5><i class="fa fa-hand-grab-o"></i> THÔNG TIN CÁ NHÂN</h5>
        </div>
    </div>
    <div class="col-xs-12 no-padding infor">
        <div class="col-sm-6 col-xs-12 no-padding web-main main-content">
            <div class="example-header title-header">
                <span>Thông Tin Bắt Buộc !</span>
            </div>
            <div class="col-xs-12 main-content">
                <div class="form-group">
                    <label>Họ Tên Của Bạn</label>
                    <div class="input-group">
                        <input type="text" name="" class="form-control submit-item input-sm width-50" placeholder ="Họ" value="{{isset($data)?$data[5][0]['first_name']:''}}" id="first_name">
                        <input type="text" name="" class="form-control submit-item input-sm width-50" placeholder="Tên" value="{{isset($data)?$data[5][0]['family_nm']:''}}" id="family_nm">
                    </div>
                </div>
                <div class="form-group">
                    <label>Tên Tài Khoản</label>
                    <div class="input-group">
                        <input type="text" name="" class="form-control submit-item input-sm" placeholder="Tên dùng để đăng nhập" value="{{isset($data)?$data[5][0]['account_nm']:''}}" id="account_nm_create">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email" name="" class="form-control submit-item input-sm" placeholder="Nhập email của bạn" value="{{isset($data)?$data[5][0]['email']:''}}" id="email">
                    </div>
                </div>
                <div class="col-xs-12"></div>
                <div class="form-group float-left">
                    <label>Ảnh Đại Diện</label>
                    <div id="imageContainer" class="{{isset($data)?'isface':''}}"></div>
                    <input type="hidden" class="submit-item" id="avatar" value="{{isset($data)?$data[5][0]['avarta']:'/web-content/images/avarta/default_avarta.jpg'}}">
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
                            <input type="text" name="" class="form-control submit-item input-sm" data-field="date" placeholder="Ngày sinh của bạn" readonly="" id="birth_date" value="{{isset($data)?$data[5][0]['birth_date']:''}}">
                        </div>
                        <div id="dtBox" style="border: 1px solid #ddd;display: none;"></div>
                    </div>
                    <div class="form-group width-50 inline-block float-left">
                        <label>Giới Tính</label>
                        <select class="form-control submit-item input-sm" id="sex">
                            @foreach($data[0] as $index => $row)
                                <option value="{{$row['lib_cd']}}" {{isset($data)&&$data[5][0]['sex'] == $row['lib_cd']?'selected=selected':''}}>{{$row['lib_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 no-padding">
                    <div class="form-group width-50 inline-block float-left">
                        <label>Nghề Nghiệp</label>
                        <select class="form-control submit-item input-sm" id="job">
                            @foreach($data[1] as $index => $row)
                                <option value="{{$row['lib_cd']}}" {{isset($data)&&$data[5][0]['job'] == $row['lib_cd']?'selected=selected':''}}>{{$row['lib_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group width-50 inline-block float-left">
                        <label>Trình Độ Tiếng Anh</label>
                        <select class="form-control submit-item input-sm" id="eng_level">
                            @foreach($data[2] as $index => $row)
                                <option value="{{$row['lib_cd']}}" {{isset($data)&&$data[5][0]['english_lv'] == $row['lib_cd']?'selected=selected':''}}>{{$row['lib_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 no-padding">
                    <div class="form-group width-50 inline-block float-left">
                        <label>Số Điện Thoại</label>
                        <div class="input-group">
                            <input type="text" name="" class="form-control numeric tel submit-item input-sm" placeholder="Nhập số điện thoại của bạn" id="cellphone" value="{{isset($data)?$data[5][0]['cellphone']:''}}">
                        </div>
                    </div>
                    <div class="form-group width-50 inline-block float-left">
                        <label>Tỉnh/Thành Phố Hiện Tại</label>
                        <select class="form-control submit-item input-sm" id="position">
                            @foreach($data[3] as $index => $row)
                                <option value="{{$row['lib_cd']}}" {{isset($data)&&$data[5][0]['position'] == $row['lib_cd']?'selected=selected':''}}>{{$row['lib_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 no-padding">
                    <div class="form-group">
                        <label>Lĩnh Vực Quan Tâm</label>
                        <select class="margin-bottom custom-selectize submit-item" id="post_tag" multiple="multiple">
                            @foreach($data[4] as $index => $row)
                                <option value="{{$row['lib_cd']}}" {{isset($data)&&in_array($row['lib_cd'],array_column($data[6],'lib_cd'))?'selected=selected':''}}>{{$row['lib_nm']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 no-padding">
                    <div class="form-group">
                        <label>Slogan Của Bạn</label>
                        <div class="input-group">
                            <textarea name="" class="form-control submit-item input-sm" rows="3" id="slogan">{{isset($data)?$data[5][0]['slogan']:''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-primary col-xs-12 margin-top" id="btn-update-infor" type="button">Cập Nhật Thông Tin</button>
    </div>
    <div class="col-xs-12 no-padding pass">
        <div class="col-xs-12 no-padding">
            <div class="right-header">
                <h5><i class="fa fa-hand-grab-o"></i> CẬP NHẬT MẬT KHẨU</h5>
            </div>
        </div>
        <div class="form-group col-xs-4 no-padding">
            <label>Mật Khẩu Cũ</label>
            <div class="input-group">
                <input type="password" name="" class="form-control submit-item input-sm" placeholder="Mật khẩu cũ" id="old_password">
            </div>
        </div>
        <div class="form-group col-xs-4 no-padding">
            <label>Mật Khẩu Mới</label>
            <div class="input-group">
                <input type="password" name="" class="form-control submit-item input-sm" placeholder="Mật khẩu mới" id="password_recreate">
            </div>
        </div>
        <div class="form-group col-xs-4 no-padding">
            <label>Xác Nhận Mật Khẩu Mới</label>
            <div class="input-group">
                <input type="password" name="" class="form-control submit-item input-sm" placeholder="Xác nhận mật khẩu mới" id="password_reconfirm">
            </div>
        </div>
        <button class="btn btn-sm btn-primary col-xs-12" id="btn-update-pass" type="button">Cập Nhật Mật Khẩu</button>
    </div>
</div>

@stop

