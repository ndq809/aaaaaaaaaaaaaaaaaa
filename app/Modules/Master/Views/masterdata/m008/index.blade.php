@extends('layout_master')
@section('title','Quản Lý Đơn Giá')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m008.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m008.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Loại Đối Tượng</h5>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right update-block">
            <div class="form-group">
                <label>Đối Tượng Đơn Giá</label>
                <select id="name_div" class="submit-item allow-selectize new-allow required">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['number_id']!='0'?$item['content']:''}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>
<div class="panel main-panel col-xs-12 update-block" id="result">
    @include('Master::masterdata.m008.search')
</div>
@stop