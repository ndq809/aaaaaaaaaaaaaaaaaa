@extends('layout_master')
@section('title','Import bài viết từ vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/writing/w003.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/writing/w003.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Dữ Liệu Đầu Vào</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
    	<div class="col-sm-3 no-padding-right">
		    <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="">
		        <div class="form-group text-center">
		            <div class="input-group">
		                <input type="file" id="word-audio" name="post_file" class="input-file" placeholder="ID của từ vựng">
		            </div>
		        </div>
		    </form>
		</div>
		<div class="col-xs-12"></div>
		<div class="col-sm-3 no-padding-right">
		    <div class="form-group">
		        <label>Block No</label>
		        <div class="input-group" style="max-width: 200px">
		          <span class="input-group-btn">
		            <button class="btn btn-primary btn-sm btn-prev" type="button"><i class="fa fa-angle-double-left"></i></button>
		          </span>
		          <input type="text" name="" id="block_no" class="form-control input-sm text-center numberic" placeholder="Vị trí bắt đầu import trong file" value="{{isset($_COOKIE['page_readed'])?$_COOKIE['page_readed']:''}}" maxlength="10" >
		          <span class="input-group-btn">
		            <button class="btn btn-primary btn-sm btn-next" type="button"><i class="fa fa-angle-double-right"></i></button>
		          </span>
		        </div><!-- /input-group -->
		    </div>
		</div>
		<div class="col-sm-3 no-padding-right">
		    <div class="form-group">
		    	<label>Tên Nhóm Khởi Tạo</label>
		        <div class="input-group">
		          <input type="text" name="" id="render-name" class="form-control input-sm text-center numberic" placeholder="" value="" maxlength="10" readonly="">
		        </div><!-- /input-group -->
		    </div>
		</div>
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left update-block" id="result">
        @include('Master::writing.w003.refer')
    </div>
</div>
@stop