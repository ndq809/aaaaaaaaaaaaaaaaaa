@extends('layout')
@section('title','E+ Đọc Hiểu')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/reading.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/reading.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> ĐỌC HIỂU TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Danh mục Bài Đọc</label>
                <select class="allow-selectize catalogue_nm" id="catalogue_nm">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm Bài Đọc</label>
                <select class="allow-selectize group_nm" id="group_nm">
                    @foreach($data_default[3] as $item)
                        <option data-data ="{{json_encode( $item)}}" value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top {{$raw_data[0][0]['btn-add-lesson']==1?'btn-add-lesson':'btn-disabled'}}">Lưu bài học này</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Những Bài Chưa Đọc</a></li>
            <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab2':'btn-disabled'}} aria-expanded="false" >Những Bài Đã Đọc</a></li>
        </ul>
        <div class="tab-content focusable" id="result1">
            @include('User::reading.right_tab')
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
        @include('User::reading.main_content')
    </div>
</div>

@stop

