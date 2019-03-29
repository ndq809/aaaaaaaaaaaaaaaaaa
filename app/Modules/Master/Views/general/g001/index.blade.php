@extends('layout_master')
@section('title','Trang Cá Nhân')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-statistic','btn-change-pass','btn-save'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Thông Tin</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="no-padding avarta-block">
            <div class="col-sm-12 no-padding-right padding-left-10">
                <div class="form-group old-item">
                    <label>Ảnh Đại Diện</label>
                    <div id="imageContainer" style="background-image: url('{{$data[1]['0']['avarta']!=''?$data[1]['0']['avarta']:'/web-content/images/avarta/default_avarta.jpg'}}');"></div>
                </div>
                <input type="hidden" class="submit-item" name="avarta" id="avarta" value="{{$data[1]['0']['avarta']!=''?$data[1]['0']['avarta']:'/web-content/images/avarta/default_avarta.jpg'}}">
            </div>
        </div>
        <div class="no-padding infor-block" >
            <div class="col-sm-3 no-padding-right">
               <div class="form-group">
                    <label>Họ Và Tên</label>
                    <div class="input-group">
                        <input type="text" id="family_nm" name="" class="form-control input-sm width-50 submit-item" placeholder="Họ và tên lót" value="{{$data[1]['0']['family_nm']}}">
                        <input type="text" id="first_name" name="" class="form-control input-sm width-50 submit-item" placeholder="Tên" value="{{$data[1]['0']['first_name']}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input id="email" type="email" name="" class="form-control input-sm submit-item" placeholder="Nhập email" maxlength="50" value="{{$data[1]['0']['email']}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <div class="input-group">
                        <input id="cellphone" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập số điện thoại" maxlength="15" value="{{$data[1]['0']['cellphone']}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Giới Tính</label>
                    <select id="sex" class="submit-item">
                        @foreach($data[0] as $item)
                            <option value="{{$item['number_id']}}" {{$data[1]['0']['sex']==$item['number_id']?'selected=selected':''}}>{{$item['content']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3 no-padding-right">
                <div class="form-group">
                    <label>Ngày Sinh</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input id="birth_date" type="text" name="" class="form-control input-sm submit-item" data-field="date" placeholder="Chọn ngày sinh" value="{{$data[1]['0']['birth_date']}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 no-padding-right">
                <div class="form-group">
                    <label>Địa Chỉ</label>
                    <div class="input-group">
                        <textarea id="address" class="form-control input-sm submit-item" placeholder="Nhập địa chỉ hiện tại của bạn" rows="4">{{$data[1]['0']['address']}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel main-panel col-xs-12 change-pass">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Mật Khẩu</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu Cũ</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm submit-item" id="old_password">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mật Khẩu Mới</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm submit-item" id="password">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Xác Nhận Mật Khẩu Mới</label>
                <div class="input-group">
                    <input type="password" name="" class="form-control input-sm submit-item" id="password_confirm">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thống Kê Công Việc Của Bạn</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-4 no-padding-right">
            <div class="form-group">
                <label>Thời Gian Tra Cứu</label>
                <div class="input-group picker">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="{{date('11/m/Y',strtotime('-1 month'))}}" readonly="" id="date-from">
                    <span class="input-group-text">~</span>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="{{date('10/m/Y')}}" readonly="" id="date-to">
                </div>
            </div>
        </div>
         <div class="col-xs-12 no-padding-right" id="result">
            @include('Master::general.g001.search',array('data'=>$data[2]))
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop