@extends('layout_master')
@section('title','Danh Sách Phân Loại')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m007.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m007.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-save','btn-delete'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Đối Tượng Phân Loại</h5>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="col-sm-3 no-padding-right update-block">
            <div class="form-group">
                <label>Lựa Chọn Đối Tượng</label>
                <select id="name_div" class="submit-item allow-selectize new-allow required">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['value']==0?'':$item['value']}}">{{$item['value']!='0'?$item['value'].'_'.$item['text']:''}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>
<div class="panel main-panel col-xs-12 update-block" id="result">
    @include('Master::masterdata.m007.search')
</div>
@stop