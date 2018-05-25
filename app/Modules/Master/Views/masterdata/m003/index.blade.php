@extends('layout_master')
@section('title','Danh Sách Nhân Viên')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete','btn-save','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/data/m004'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
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
                <label>Phòng Ban</label>
                <div class="input-group">
                    <input data-refer="p001" id="department_id" class="form-control input-sm input-refer submit-item" placeholder="Nhập mã phòng ban"> 
                    <span class="input-group-btn"> 
                        <a class="btn btn-primary btn-sm btn-popup" type="button" href="/master/popup/p001">Tìm Kiếm</a> 
                    </span> 
                </div>
            </div>
        </div>
    	<div class="col-sm-3 no-padding-right">
    	    <div class="form-group">
    	        <label>Loại Nhân Viên</label>
	            <select id="employee_div" class="submit-item allow-selectize">
	                @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
	            </select>
    	    </div>
    	</div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div id="result" class="panel main-panel col-xs-12">
	@include('Master::masterdata.m003.search')
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title inline-block">Cập Nhật Thông Tin</h5>
        <a class="float-right edit-save"><span class="fa fa-hand-o-up"></span> Cập nhật sửa đổi</a>
    </div>
    <div class="panel-content no-padding-left update-block">
        <div class="no-padding avarta-block">
            <div class="col-sm-12 no-padding-right">
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
                        <input id="emp_id" type="text" name="" class="form-control input-sm submit-item key-item" placeholder="Mã nhân viên" readonly="">
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
                        @foreach($data_default[1] as $item)
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
                        @foreach($data_default[0] as $item)
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
</div>
@stop