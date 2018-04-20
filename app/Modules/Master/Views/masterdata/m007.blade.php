@extends('layout_master')
@section('title','Danh Sách Phân Loại')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/masterdata/m007.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/masterdata/m007.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save','btn-print'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Đối Tượng Phân Loại</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Lựa Chọn Đối Tượng</label>
                <select class="new-allow">
                    <option>Tất cả</option>
                    <option>DC</option>
                    <option>UC</option>
                    <option>MC</option>
                </select>
            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Chi Tiết Đối Tượng</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='1160px'>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                            <th width="150px">Mã Hạng Mục</th>
                            <th>Tên Hạng Mục</th>
                            <th width="100px">Ngoại Lệ 1</th>
                            <th width="100px">Ngoại Lệ 2</th>
                            <th width="100px">Ngoại Lệ 3</th>
                            <th>Ghi Chú 1</th>
                            <th>Ghi Chú 2</th>
                            <th>Ghi Chú 3</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hidden">
                            <td></td>
                            <td><input type="text" name="" class="form-control input-sm required" value="1" readonly=""></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="1"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="2"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="3"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                        @for($i=1;$i<=5;$i++)
                        <tr>
                            <td>{{$i}}</td>
                            <td><input type="text" name="" class="form-control input-sm required" value="1" readonly=""></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="1"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="2"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="3"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-bottom">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
</div>
@stop