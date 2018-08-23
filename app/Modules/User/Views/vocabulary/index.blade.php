@extends('layout')
@section('title','E+ Học Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.cssslider.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/vocabulary.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/animated-slider.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/vocabulary.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> HỌC TỪ VỰNG TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Danh mục từ vựng</label>
                <select class="allow-selectize" id="catalogue_nm">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm từ vựng</label>
                <select class="allow-selectize" id="group_nm">
                    <option></option>
                </select>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top" id="btn-add-lesson">Lưu bài học này</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Từ Vựng Chưa Thuộc</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Từ Vựng Đã Thuộc</a></li>
        </ul>
        <div class="tab-content focusable" id="result1">
            @include('User::vocabulary.right_tab')
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
		@include('User::vocabulary.main_content')
	</div>
</div>

@stop

