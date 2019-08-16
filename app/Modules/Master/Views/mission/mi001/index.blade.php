@extends('layout_master')
@section('title','Danh Sách Nhiệm Vụ')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/mission/mi001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/mission/mi001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-confirm','btn-public','btn-reset-status','btn-delete','btn-add-page'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/mission/mi002'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Nhiệm Vụ</label>
                <select id="mission_div" class="submit-item">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Dữ Liệu Nhiệm Vụ</label>
                <select id="mission_data_div" class="submit-item">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                <select id="catalogue_div" class="submit-item">
                    @foreach($data_default[2] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Trạng Thái</label>
                <select id="record_div" class="submit-item">
                    @foreach($data_default[3] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4 no-padding-right">
            <div class="form-group">
                <label>Giới Hạn Rank</label>
                <div class="input-group">
                    <select id="rank-from" class="submit-item">
                        @foreach($data_default[4] as $item)
                            <option value="{{$item['number_id']}}" placeholder="Rank bắt đầu">{{$item['content']}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">~</span>
                    <select id="rank-to" class="submit-item">
                        @foreach($data_default[4] as $item)
                            <option value="{{$item['number_id']}}" placeholder="Rank kết thúc" class="hidden">{{$item['content']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-8 no-padding-right">
            <div class="form-group">
                <label>Tên Nhiệm Vụ</label>
                <div class="input-group">
                    <input id="mission_nm" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập tên nhiệm vụ" maxlength="50">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="result" class="panel main-panel col-xs-12 ">
    @include('Master::mission.mi001.search')
</div>
@stop