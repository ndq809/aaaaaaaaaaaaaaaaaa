@extends('popup_master')
@section('title','Kiểm Tra Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/fieldsLinker.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/fieldsLinker.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen/p002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/p002.css')!!}
@stop
@section('button')
    {{Button::menu_button(array('btn-check','btn-refresh','btn-close'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12 test1">
	<div class="panel-header">
		<label class="text-danger">Nối từ tiếng anh ở cột bên trái với nghĩa tương ứng ở cột bên phải</label>
	</div>
    <div class="panel-content no-padding-left search-block">
        <div class="form-group">
            <div id="test1" style="overflow: auto;"></div>
        </div>
    </div>
</div>
<div class="panel main-panel col-xs-12 test2 hidden">
    <div class="panel-header">
        <label class="text-danger">Điền từ tiếng anh của nghĩa được ghi ở bên trái</label>
    </div>
    <div class="panel-content no-padding-left search-block">
        <div class="form-group">
            <div id="test2" style="overflow: auto;">
                <div class="table-fixed-width no-padding-left" min-width='320px'>
                    <table class="table table-hover table-bordered table-focus table-input">
                        <thead>
                            <tr>
                                <th >STT</th>
                                <th >Nghĩa Tiếng Việt</th>
                                <th width="200px">Nhập Từ Tiếng Anh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hidden">
                                <td width="40px"></td>
                                <td></td>
                                <td><input type="text" name="" class="form-control input-sm voc-list"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
