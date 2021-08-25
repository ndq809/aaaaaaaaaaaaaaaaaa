@extends('layout_master')
@section('title','Quản Lý Phân Quyền')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/system/s001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/system/s001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Đối Tượng Phân Quyền</h5>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Đối tượng thao tác</label>
                <select id="target_div" class="required">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Tài Khoản</label>
                <select id="account_div" class="submit-item required">
                    @foreach($data_default[1] as $item)
                        <option value="{{$item['value']==0?'':$item['value']}}" user_div ='{{$item["user_div"]}}'>{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>
<div class="panel main-panel col-xs-12" id="result">
    @include('Master::system.s001.search')
</div>
@stop
