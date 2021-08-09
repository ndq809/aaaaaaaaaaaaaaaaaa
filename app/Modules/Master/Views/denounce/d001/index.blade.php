@extends('layout_master')
@section('title','Xử Lý Tố Cáo')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/denounce/d001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/denounce/d001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-list','btn-execute'))}}
@endsection
@section('content')
<div class="link-div" btn-add-page-link='/master/denounce/s003'></div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Lọc Danh Sách</h5>
	</div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-2 no-padding-right">
            <div class="form-group">
                <label>Khoảng Thời Gian</label>
                <select id="time_div_s" class="form-control input-sm">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4 no-padding-right">
            <div class="form-group">
                <label>Thời Gian Chỉ Định</label>
                <div class="input-group picker">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="submit-item form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="" readonly="" id="date-from">
                    <span class="input-group-text">~</span>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="submit-item form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="" readonly="" id="date-to">
                </div>
            </div>
        </div>
        <div class="col-sm-2 no-padding-right">
            <div class="form-group">
                <label>Tên Người Dùng Bị Tố Cáo</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm submit-item" id="username" maxlength="50">
                </div>
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div id="result" >
	@include('Master::denounce.d001.search')
</div>
@stop