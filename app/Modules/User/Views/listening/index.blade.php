@extends('layout')
@section('title','E+ Học Nghe')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.jplayer.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jplayer.playlist.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/listening.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/jplayer.blue.monday.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/listening.css')!!}
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
                        <td class="text-center"><h5><i class="{{isset($data_default[0])?'glyphicon glyphicon-education':'fa fa-futbol-o fa-spin'}}"></i> {{isset($data_default[0])?'HỌC NGHE TIẾNG ANH':'NV : '.(session('mission')['title'])}}</h5></td>
                        <td class="text-right"><h5 class="margin-right float-right noselect" id="btn_next">TIẾP <i class="glyphicon glyphicon-fast-forward"></i></h5></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	<div class="col-md-4 col-md-push-8 right-tab no-padding" >
        <div class="col-md-12 no-padding select-group">
            <div class="form-group">
                <label>Danh Mục Bài Nghe</label>
                <select class="allow-selectize catalogue_nm" id="catalogue_nm" {{isset($data_default[0])?'':'disabled'}}>
                    @if(isset($data_default[0]))
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm Bài Nghe</label>
                <select class="allow-selectize group_nm" id="group_nm" {{isset($data_default[0])?'':'disabled'}}>
                    @if(isset($data_default[0]))
                    @foreach($data_default[3] as $item)
                        <option data-data ="{{json_encode( $item)}}" value="{{$item['value']}}">{{$item['text']}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top {{$raw_data[0][0]['btn-add-lesson']==1?'btn-add-lesson':'btn-disabled'}}"  {{isset($data_default[0])?'':'disabled'}}>Lưu bài học này</button>
        </div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Những Bài Chưa Nghe</a></li>
            <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab2':'btn-disabled'}} aria-expanded="false" >Những Bài Đã Nghe</a></li>
        </ul>
        <div class="tab-content focusable" id="result1">
            @include('User::listening.right_tab')
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
		@if(!isset($blank))
            @include('User::listening.main_content')
        @else
            @include('not_found')
        @endif
	</div>
</div>

@stop

