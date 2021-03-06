@extends('layout')
@section('title','E+ Tập Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/writing.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/writing.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
    <div class="temp hidden" style="height:27px"></div>
	<div class="right-header col-md-12 no-padding">
        <div class="col-md-8 no-padding">
            <table class="full-width">
                <tbody>
                    <tr>
                        <td class="text-left"><h5 class="noselect" id="btn_prev"><i class="glyphicon glyphicon-fast-backward"></i> TRƯỚC</h5></td>
                        <td class="text-center"><h5><i class="glyphicon glyphicon-education"></i> TẬP VIẾT TIẾNG ANH</h5></td>
                        <td class="text-right"><h5 class="margin-right float-right noselect" id="btn_next">TIẾP <i class="glyphicon glyphicon-fast-forward"></i></h5></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
            <div class="form-group">
                <label>Danh Mục Bài Mẫu</label>
                <select class="allow-selectize catalogue_nm" id="catalogue_nm">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm Bài Mẫu</label>
                <select class="allow-selectize group_nm" id="group_nm">
                    @foreach($data_default[3] as $item)
                        <option data-data ="{{json_encode( $item)}}" value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top {{$raw_data[0][0]['btn-add-lesson']==1?'btn-add-lesson':'btn-disabled'}}" {{$raw_data[0][0]['btn-add-lesson']==1?'':'rank='.$raw_data[0][0]['btn-add-lesson']}}>Lưu bài học này</button>
        </div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài Mẫu Hệ Thống</a></li>
            <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab2':'btn-disabled rank='.$raw_data[0][0]['btn-forget']}} aria-expanded="false" >Bài Viết Của Bạn</a></li>
        </ul>
        <div class="tab-content focusable">
            <div id="tab1" class="tab-pane fade active in">
                @include('User::writing.right_tab')
            </div>
            <div id="tab2" class="tab-pane fade">
                @include('User::writing.right_tab1')
            </div>
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
        <div class="col-xs-12 no-padding writing-tab">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#tab-custom1">Xem Bài Viết Mẫu</a></li>
                <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab-custom2':'btn-disabled rank='.$raw_data[0][0]['btn-forget']}} aria-expanded="false" >Bắt Đầu Tập Viết</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-custom1" class="tab-pane fade in active">
                    @if(!isset($blank))
                        @include('User::writing.tab_custom1')
                    @else
                        @include('not_found')
                    @endif
                </div>
                <div id="tab-custom2" class="tab-pane fade input-tab">
                    @include('User::writing.tab_custom2')
                </div>
            </div>
        </div>
        <div class="example-content">
            @if(!isset($blank))
                @include('User::writing.main_content')
            @endif
        </div>
    </div>
</div>

@stop

