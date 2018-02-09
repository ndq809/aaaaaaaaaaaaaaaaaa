@extends('layout_master')
@section('title','Danh Sách Ngữ Pháp')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/grammar/g001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/grammar/g001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/g004'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left">
    	<div class="col-sm-3 no-padding-right">
    	    <div class="form-group">
    	        <label>Danh Mục Ngữ Pháp</label>
    	        <div class="input-group">
    	            <select class="form-control input-sm">
    	                <option>this is select box</option>
    	            </select>
    	        </div>
    	    </div>
    	</div>
    	<div class="col-sm-3 no-padding-right">
    	    <div class="form-group">
    	        <label>Nhóm Ngữ Pháp</label>
    	        <div class="input-group">
    	            <select class="form-control input-sm">
    	                <option>this is select box</option>
    	            </select>
    	        </div>
    	    </div>
    	</div>
    	<div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Từ Khóa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Từ khóa của từ vựng">
                </div>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header padding-10-l">
		<h5 class="panel-title">Danh Sách Ngữ Pháp</h5>
	</div>
	<div class="panel-content padding-10-l show-on-click" click-btn='btn-list'>
		<div class="table-fixed-width no-padding-left" min-width='768px'>
            <table class="table table-hover table-bordered table-focus">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tiêu Đề</th>
                        <th>Danh Mục</th>
                        <th>Nhóm</th>
                        <th>Tóm Tắt Nội Dung</th>
                    </tr>
                </thead>
                <tbody>
                	@for($i=1;$i<=15;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td class="update-item">{{$i}}</td>
                        <td class="update-item">Abide by</td>
                        <td class="update-item">600 từ vựng toleic</td>
                        <td class="update-item">business</td>
                        <td class="update-item text-left">Người theo hương hoa mây mù giăng lối</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <ul class="pager">
            <li><a href="#">Hàng Trước</a></li>
            <li><a href="#">Hàng Tiếp</a></li>
        </ul>
	</div>
	<div class="panel-bottom">
		<i class="fa fa-spinner fa-spin"></i>
	</div>
</div>
<div class="panel main-panel col-xs-12 show-on-click" click-btn='btn-list'>
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Ngữ Pháp</h5>
    </div>
    <div class="panel-content no-padding-left update-content">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>ID</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="ID của từ vựng" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Ngữ Pháp</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nhóm Của Ngữ Pháp</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Tiêu Đề Ngữ Pháp</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên từ vựng">
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Nội Dung Ngữ Pháp</label>
                <div class="input-group">
                    <textarea name="gra-content" class="form-control input-sm ckeditor" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-bottom">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
</div>
@stop