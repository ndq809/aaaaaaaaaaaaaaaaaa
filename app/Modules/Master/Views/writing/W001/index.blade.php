@extends('layout_master')
@section('title','Danh Sách Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/writing/w001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/writing/w001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-confirm','btn-public','btn-reset-status','btn-delete','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/writing/w002'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
       <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                 <select class="allow-selectize submit-item " id="catalogue_div_s">
                     @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select class="submit-item allow-selectize new-allow" id="catalogue_nm_s">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm_s" class="submit-item allow-selectize new-allow">
                        <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Trạng Thái</label>
                <select id="record_div" class="submit-item">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Tiêu Đề Của Bài Viết</label>
                <div class="input-group">
                    <input type="text" id="post_title" name="" class="form-control input-sm submit-item" placeholder="Tiêu đề bài viết">
                </div>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12" id="result">
	@include('Master::writing.w001.search')
</div>
@stop