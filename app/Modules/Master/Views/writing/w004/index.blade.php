@extends('layout_master')
@section('title','Import bài viết đọc hiểu')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/compromise/builds/compromise.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.highlight-within-textarea.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/jquery.highlight-within-textarea.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen_master/writing/w004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/writing/w004.css')!!}
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
    	<div class="col-sm-6 no-padding-right">
		    <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="">
		        <div class="form-group text-center">
		            <div class="input-group">
		                <input type="file" id="word-audio" name="post_file" class="input-file" placeholder="ID của từ vựng">
		            </div>
		        </div>
		    </form>
		</div>
		<div class="col-xs-12"></div>
		<div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
		    <div class="form-group">
		        <label>Tên Danh Mục</label>
		        <select class="submit-item allow-selectize new-allow required" id="catalogue_nm">
		            <option value=""></option>
		            @foreach($data[0] as $item)
		                <option value="{{$item['value']==0?'':$item['value']}}">{{$item['text']}}</option>
		            @endforeach
		        </select>
		    </div>
		</div>
		<div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
		    <div class="form-group">
		        <label>Tên Nhóm</label>
		        <select id="group_nm" class="submit-item allow-selectize new-allow required">
		                <option value=""></option>
		        </select>
		    </div>
		</div>
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left update-block" id="result">
        @include('Master::writing.w004.refer')
    </div>
</div>
@stop