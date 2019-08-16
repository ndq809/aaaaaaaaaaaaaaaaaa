@extends('layout_master')
@section('title','Thêm Mới Nhiệm Vụ')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/mission/mi002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/mission/mi002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-save','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/mission/mi001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thiết Lập Nhiệm Vụ</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
        @include('Master::mission.mi002.refer')
    </div>
</div>
<div class="panel main-panel col-xs-12 mission-user-panel hidden">
    <div class="panel-header">
        <h5 class="panel-title">Đối Tượng Thực Hiện</h5>
    </div>
    <div class="col-sm-12 no-padding-right" type="">
	    <div class="form-group table-fixed-width" min-width="1024px">
	        <a type="button" href="/master/popup/p006" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách đối tượng</a>
	        <div class="result">
	            @include('Master::mission.mi002.refer_user')
	        </div>
	    </div>
	</div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Chi Tiết Nhiệm Vụ</h5>
    </div>
    <div class="col-sm-12 no-padding-right transform-content hidden" type="0">
	    <div class="form-group table-fixed-width" min-width="1024px">
	        <a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách từ vựng</a>
	        <div class="result">
	            @include('Master::mission.mi002.refer_voc')
	        </div>
	    </div>
	</div>
	 <div class="col-sm-12 no-padding-right transform-content hidden" type="1">
	    <div class="form-group table-fixed-width" min-width="1024px">
	        <a type="button" href="/master/popup/p005" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách bài viết</a>
	        <div class="result">
	            @include('Master::mission.mi002.refer_post')
	        </div>
	    </div>
	</div>
	<div class="col-sm-12 no-padding-right transform-content hidden" type="2">
	    <div class="form-group table-fixed-width" min-width="1024px">
	        <div class="result">
	        </div>
	    </div>
	</div>
</div>
@stop