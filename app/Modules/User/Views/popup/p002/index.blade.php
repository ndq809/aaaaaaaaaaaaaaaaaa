@extends('popup_master')
@section('title','Kiểm Tra Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/fieldsLinker.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/fieldsLinker.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen/p002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/p002.css')!!}
@stop
@section('button')
    {{Button::menu_button(array('btn-save-user','btn-refresh','btn-close'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<label class="text-danger">Nối từ tiếng anh ở cột bên trái với nghĩa tương ứng ở cột bên phải</label>
	</div>
    <div class="panel-content no-padding-left search-block">
        <div class="form-group" min-width="1024px">
            <div id="bonds" style="overflow: auto;"></div>
            <div id="bonds1" style="overflow: auto;">
                <div class="table-fixed-width no-padding-left" min-width='1160px'>
                    <table class="table table-hover table-bordered table-focus">
                        <thead>
                            <tr>
                                <th width="100px">Nghĩa Tiếng Việt</th>
                                <th width="80px">Nhập Từ Tiếng Anh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hidden">
                                <td></td>
                                <td></td>
                                <td><input type="" name=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
